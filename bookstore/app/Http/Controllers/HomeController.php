<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Post;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostsRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use App\Services\BookService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    protected $productRepository;
    protected $categoryRepository;
    protected $postsRepository;
    protected $supplierRepository;
    protected $bookService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        PostsRepositoryInterface $postsRepository,
        BannerRepositoryInterface $bannerRepository,
        SupplierRepositoryInterface $supplierRepository,
        BookService $bookService
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postsRepository = $postsRepository;
        $this->bannerRepository = $bannerRepository;
        $this->supplierRepository = $supplierRepository;
        $this->bookService = $bookService;
    }

    public function index()
    {
        $banners = $this->bannerRepository->getAllBanner();
        $featuredBooks = $this->productRepository->getfeaturedBooks();
        $booksByCategory = $this->categoryRepository->getBooksByCategory();

        return view('home', compact('banners', 'featuredBooks', 'booksByCategory'));
    }

    public function bill() {
        $orderPending = Order::where('customer_id', Auth::user()->id)->pending()->get();
        $orderProcess = Order::where('customer_id', Auth::user()->id)->process()->get();

        return view('bill', compact('orderPending', 'orderProcess'));
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        Session::flash();
        return redirect()->route('login');
    }

    public function productDetails($slug)
    {
        $product = $this->productRepository->getProductBySlug($slug);
        $similarProducts = $this->productRepository->getAllSimilarProducts(
            $product->id,
            data_get($product, 'category_id')
        );
        $comments = Comment::where('product_id', $product->id)
            ->whereNull('comment_id')
            ->with('children', 'customer')
            ->get();
        $reviews = Review::query()->where('product_id', $product->id)->paginate(6);

        $cart = Cart::content() ?? [];

        $quantity = $cart->first(function ($item) use ($product) {
            return $product->id === $item->id;
        })->qty ?? 1;


        return view('details', compact('product', 'quantity', 'reviews', 'comments', 'similarProducts'));
    }

    public function aboutUs()
    {
        $news = Post::query()->limit(4)->latest()->get();
        $posts = Post::query()->paginate(5);
        return view('about-us', compact('posts', 'news'));
    }

    public function contact()
    {
        return view('contact-form');
    }

    public function sendTheContact(ContactRequest $request)
    {
        try {
            $contact = $request->validated();
            Contact::create($contact);

            toastr()->info(__('Chúng tôi sẽ xem xét và phản hồi bạn sớm nhất có thể'), 'Thông báo');
        } catch (\Exception $e) {
            record_error_log($e);
        }

        return back();

    }

    public function search(Request $request)
    {
        $key_word = $request->input('q');
        $sortBy = ['column' => 'created_at', 'sort' => 'DESC'];
        $books = $this->productRepository->getProductByCondition($key_word, $sortBy);
        $totalBooks = $books->count();

        if (empty($key_word)) {
            return redirect()->route('home');
        }

        return view('search-book', compact('key_word', 'books', 'totalBooks'));
    }

    public function posts()
    {
        $news = Post::query()->limit(4)->latest()->get();
        $posts = Post::query()->paginate(5);
        return view('post-list', compact('posts', 'news'));
    }

    public function accountInformation()
    {
        return back();
    }

    public function productsOfList($slug = null)
    {
        $params = ['slug' => $slug];
        $books = $this->productRepository->search($params);
        $category = $this->categoryRepository->getCategoryBySlug($slug) ?? null;

        return view('book_by_category', compact('category', 'books', 'slug'));
    }

    public function searchBooksByCategory(Request $request): JsonResponse
    {
        $params = $request->all();
        $params['option'] = $this->bookService->sortByColumn($params['option']);
        $books = $this->productRepository->search($params);

        return $this->response(200, 'OK', [
            'books' => $books,
            'pagination' => view(
                'common.pagination',
                ['paginator' => $books]
            )->render()
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function showFormChangePassword()
    {
        return view('profile.change-password');
    }

    public function postDetail($slug)
    {
        $news = Post::query()->latest()->limit(4)->get();
        $post = Post::query()->where('slug', $slug)->first();

        return view('post', compact('post', 'news'));
    }
}
