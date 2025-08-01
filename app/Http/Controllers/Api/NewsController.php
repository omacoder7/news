<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Получить список всех новостей
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $author = $request->get('author');
        
        $query = News::query();
        
        // Поиск по названию или описанию
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Фильтр по автору
        if ($author) {
            $query->where('author', $author);
        }
        
        $news = $query->orderBy('created_at', 'desc')
                      ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => [
                'news' => $news->items(),
                'pagination' => [
                    'current_page' => $news->currentPage(),
                    'last_page' => $news->lastPage(),
                    'per_page' => $news->perPage(),
                    'total' => $news->total(),
                    'from' => $news->firstItem(),
                    'to' => $news->lastItem(),
                ]
            ],
            'message' => 'Новости успешно получены'
        ]);
    }

    /**
     * Получить подробную информацию о новости
     */
    public function show($id): JsonResponse
    {
        try {
            $news = News::findOrFail($id);
            
            // Получаем связанные новости того же автора
            $relatedNews = News::where('author', $news->author)
                              ->where('id', '!=', $news->id)
                              ->orderBy('created_at', 'desc')
                              ->take(3)
                              ->get();
            
            // Статистика автора
            $authorStats = News::where('author', $news->author)
                              ->selectRaw('COUNT(*) as total_news, MAX(created_at) as last_news_date')
                              ->first();
            
            $response = [
                'success' => true,
                'data' => [
                    'news' => [
                        'id' => $news->id,
                        'name' => $news->name,
                        'description' => $news->description,
                        'author' => $news->author,
                        'photo' => $news->photo ? asset($news->photo) : null,
                        'created_at' => $news->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $news->updated_at->format('Y-m-d H:i:s'),
                        'created_at_formatted' => $news->created_at->format('d.m.Y H:i'),
                        'updated_at_formatted' => $news->updated_at->format('d.m.Y H:i'),
                    ],
                    'author_info' => [
                        'name' => $news->author,
                        'total_news' => $authorStats->total_news,
                        'last_news_date' => $authorStats->last_news_date ? 
                            \Carbon\Carbon::parse($authorStats->last_news_date)->format('d.m.Y H:i') : null,
                    ],
                    'related_news' => $relatedNews->map(function($item) {
                        return [
                            'id' => $item->id,
                            'name' => $item->name,
                            'description' => Str::limit($item->description, 100),
                            'photo' => $item->photo ? asset($item->photo) : null,
                            'created_at' => $item->created_at->format('d.m.Y H:i'),
                        ];
                    }),
                ],
                'message' => 'Информация о новости успешно получена'
            ];
            
            return response()->json($response);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Новость не найдена',
                'error' => 'News not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при получении новости',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Получить статистику по новостям
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'total_news' => News::count(),
                'total_authors' => News::distinct('author')->count(),
                'latest_news' => News::latest()->first() ? 
                    News::latest()->first()->created_at->format('d.m.Y H:i') : null,
                'top_authors' => News::selectRaw('author, COUNT(*) as news_count')
                                    ->groupBy('author')
                                    ->orderBy('news_count', 'desc')
                                    ->take(5)
                                    ->get()
                                    ->map(function($item) {
                                        return [
                                            'author' => $item->author,
                                            'news_count' => $item->news_count
                                        ];
                                    }),
                'news_by_month' => News::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                                      ->groupBy('year', 'month')
                                      ->orderBy('year', 'desc')
                                      ->orderBy('month', 'desc')
                                      ->take(6)
                                      ->get()
                                      ->map(function($item) {
                                          return [
                                              'period' => $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT),
                                              'count' => $item->count
                                          ];
                                      })
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Статистика успешно получена'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при получении статистики',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Получить новости по автору
     */
    public function byAuthor($author): JsonResponse
    {
        try {
            $news = News::where('author', $author)
                       ->orderBy('created_at', 'desc')
                       ->get()
                       ->map(function($item) {
                           return [
                               'id' => $item->id,
                               'name' => $item->name,
                               'description' => Str::limit($item->description, 150),
                               'photo' => $item->photo ? asset($item->photo) : null,
                               'created_at' => $item->created_at->format('d.m.Y H:i'),
                               'updated_at' => $item->updated_at->format('d.m.Y H:i'),
                           ];
                       });
            
            if ($news->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Новости автора не найдены',
                    'data' => []
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'author' => $author,
                    'total_news' => $news->count(),
                    'news' => $news
                ],
                'message' => 'Новости автора успешно получены'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Произошла ошибка при получении новостей автора',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
