namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository
implements CategoryRepositoryInterface
{
    public function getAll()
    {
        return Category::latest()
               ->paginate(20);
    }

    public function find($id)
    {
        return Category::findOrFail($id);
    }

    public function store(array $data)
    {
        return Category::create($data);
    }

    public function update($id,array $data)
    {
        $category =
        Category::findOrFail($id);

        return $category->update($data);
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }
}