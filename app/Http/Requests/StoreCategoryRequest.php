namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'name' =>
            'required|max:255',

            'icon' =>
            'nullable|image|mimes:jpg,jpeg,png,webp',

            'status' =>
            'required|boolean'
        ];
    }
}