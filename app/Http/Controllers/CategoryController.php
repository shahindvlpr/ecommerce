namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories =
        Category::latest()->paginate(10);

        return view(
            'admin.category.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view(
            'admin.category.create'
        );
    }

    public function store(
        StoreCategoryRequest $request
    )
    {
        $data = $request->validated();

        $data['slug'] =
        Str::slug($request->name);

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category Created Successfully'
            );
    }

    public function edit(Category $category)
    {
        return view(
            'admin.category.edit',
            compact('category')
        );
    }

    public function update(
        StoreCategoryRequest $request,
        Category $category
    )
    {
        $data = $request->validated();

        $data['slug'] =
        Str::slug($request->name);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index');
    }

    public function destroy(
        Category $category
    )
    {
        $category->delete();

        return back();
    }
}