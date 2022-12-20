<?php

namespace App\Http\Requests;

use App\Models\Item;
use Illuminate\Auth\Access\Response as Access;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class ApplyUnitsRequest extends FormRequest
{
    /**
     * @var Illuminate\Database\Eloquent\Collection
     */
    public $items;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Fetching items are placed here to limit going back and forth
        // to the database and the possibility that the items won't be
        // available next fetch.
        $this->items = Item::available($this->quantity)->get();

        if ($this->items->count() != $this->quantity) {
            return Access::denyWithStatus(Response::HTTP_UNPROCESSABLE_ENTITY, 'Quantity to be applied exceeds the quantity on hand.');
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
