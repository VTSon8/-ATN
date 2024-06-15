<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\Banner\BannerRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostsRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Supplier\SupplierRepositoryInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\District;
use App\Models\Product;
use App\Models\Province;
use App\Models\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    protected $productRepository;
    protected $categoryRepository;
    protected $postsRepository;
    protected $supplierRepository;

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
        SupplierRepositoryInterface $supplierRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postsRepository = $postsRepository;
        $this->bannerRepository = $bannerRepository;
        $this->supplierRepository = $supplierRepository;
    }
    public function index()
    {
        $banners = $this->bannerRepository->getAllBanner();
        $featuredBooks = $this->productRepository->getfeaturedBooks();
//        $sellingBooks = $this->productRepository->getSellingBooks();
        $booksByCategory = $this->categoryRepository->getBooksByCategory();

        return view('home', compact('banners','featuredBooks', 'booksByCategory'));
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect()->route('login');
    }

    public function productDetails($slug)
    {

        $product = $this->productRepository->getProductBySlug($slug);
        $similarProducts = $this->productRepository->getAllSimilarProducts($product->id,
            data_get($product, 'category_id'));
        $comments = Comment::where('product_id', $product->id)
            ->whereNull('comment_id')
            ->with('children', 'customer')
            ->get();
        $reviews = Review::query()->where('product_id', $product->id)->paginate(6);

        $cart = Cart::content() ?? [];

        $quantity = $cart->first(function ($item) use ($product) {
            return $product->id === $item->id;
        })->qty ?? 1;


        return view('details', compact('product', 'quantity', 'reviews','comments', 'similarProducts'));
    }

    public function introduce()
    {
        return view('introduce.index');
    }

    public function contact()
    {
        return view('contact.index');
    }

    public function sendTheContact(ContactRequest $request)
    {
        DB::beginTransaction();
        try {
            $contact = $request->validated();
            Contact::create($contact);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            record_error_log($e);
            return back();
        }

        toastr()->info(__('Chúng tôi sẽ xem xét và phản hồi bạn sớm nhất có thể'), 'Thông báo');
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
        return view('post.index', compact('posts', 'news'));
    }

    public function accountInformation()
    {
        return back();
    }

    public function productsOfList($slug = null)
    {
        $category = [];
        $books = $this->productRepository->getAllProduct();
        $authors = $this->productRepository->getAuthorAll();
        $suppliers = $this->supplierRepository->getAllSupplier();

        if ($slug !== 'all') {
            $category = $this->categoryRepository->getCategoryBySlug($slug);

            if($category) {
                $books = $this->productRepository->getProductByCategory($category->slug);
            }
        }

        return view('book_by_category', compact('category','books', 'authors', 'suppliers'));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $key_word = $request->key_word;
        $sortBy = sortByColumn($request->sort);
        $products = $this->productRepository->getProductByCondition($key_word, $sortBy);
        $category = $this->categoryRepository->getCategoryBySlug($request->slug);
        if ($category) {
            $products = $category->productsRecursive($key_word, $sortBy)->paginate(config('constants.PER_PAGE'));
        }

        return respond(200, 'OK', [
            'product' => $products,
            'pagination' => view('admin.common.pagination',
                ['paginator' => $products])->render()
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

        return view('post.detail', compact('post', 'news'));
    }
}
