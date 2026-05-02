<?php

namespace App\Http\Controllers;

use App\Models\ListingOption;
use App\Models\ListingOptionCategory;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminListingOptionController extends Controller
{
    public function index(): View
    {
        $categories = ListingOptionCategory::query()->orderBy('sort_order')->get();

        return view('admin.listing-options.index', [
            'categories' => $categories,
        ]);
    }

    public function show(ListingOptionCategory $category): View
    {
        $options = ListingOption::query()
            ->where('category_id', $category->id)
            ->with('parent')
            ->orderByRaw('parent_id is null desc')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->orderBy('value')
            ->get();

        $makeOptions = $category->slug === 'model'
            ? ListingOption::query()
                ->where('category_id', ListingOptionCategory::query()->where('slug', 'make')->value('id'))
                ->whereNull('parent_id')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('value')
                ->get()
            : collect();

        return view('admin.listing-options.show', [
            'category' => $category,
            'options' => $options,
            'makeOptions' => $makeOptions,
        ]);
    }

    public function store(Request $request, ListingOptionCategory $category): RedirectResponse
    {
        $isModel = $category->slug === 'model';

        $data = $request->validate([
            'value' => ['required', 'string', 'max:255'],
            'parent_id' => [$isModel ? 'required' : 'nullable', 'integer', 'exists:listing_options,id'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $parentId = $data['parent_id'] ?? null;
        if ($isModel) {
            $makeCategory = ListingOptionCategory::query()->where('slug', 'make')->firstOrFail();
            $parent = ListingOption::query()->whereKey((int) $parentId)->firstOrFail();
            if ((int) $parent->category_id !== (int) $makeCategory->id || $parent->parent_id !== null) {
                return back()->withErrors(['parent_id' => __('Choose a valid Make as parent.')])->withInput();
            }
        } else {
            $parentId = null;
        }

        $maxSort = (int) ListingOption::query()->where('category_id', $category->id)
            ->where('parent_id', $parentId)
            ->max('sort_order');

        ListingOption::query()->create([
            'category_id' => $category->id,
            'parent_id' => $parentId,
            'value' => trim($data['value']),
            'sort_order' => $maxSort + 1,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return back()->with('status', __('Option added.'));
    }

    public function update(Request $request, ListingOptionCategory $category, ListingOption $option): RedirectResponse
    {
        $this->assertOptionCategory($category, $option);

        $request->validate([
            'value' => ['required', 'string', 'max:255'],
        ]);

        $option->update([
            'value' => trim((string) $request->input('value')),
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('status', __('Option updated.'));
    }

    public function destroy(ListingOptionCategory $category, ListingOption $option): RedirectResponse
    {
        $this->assertOptionCategory($category, $option);

        if ($option->children()->exists()) {
            return back()->withErrors(['option' => __('Remove or reassign child model options first.')]);
        }

        $usage = $this->usageCount($category->slug, $option);
        if ($usage > 0) {
            return back()->withErrors(['option' => __('Cannot delete: :count listing(s) still use this value.', ['count' => $usage])]);
        }

        $option->delete();

        return back()->with('status', __('Option deleted.'));
    }

    public function move(Request $request, ListingOptionCategory $category, ListingOption $option): RedirectResponse
    {
        $this->assertOptionCategory($category, $option);

        $data = $request->validate([
            'direction' => ['required', 'in:up,down'],
        ]);

        $siblingQuery = ListingOption::query()
            ->where('category_id', $category->id)
            ->where('parent_id', $option->parent_id);

        if ($data['direction'] === 'up') {
            $swap = (clone $siblingQuery)->where('sort_order', '<', $option->sort_order)->orderByDesc('sort_order')->first();
        } else {
            $swap = (clone $siblingQuery)->where('sort_order', '>', $option->sort_order)->orderBy('sort_order')->first();
        }

        if ($swap) {
            $a = $option->sort_order;
            $option->update(['sort_order' => $swap->sort_order]);
            $swap->update(['sort_order' => $a]);
        }

        return back();
    }

    protected function assertOptionCategory(ListingOptionCategory $category, ListingOption $option): void
    {
        abort_if((int) $option->category_id !== (int) $category->id, 404);
    }

    protected function usageCount(string $categorySlug, ListingOption $option): int
    {
        $column = match ($categorySlug) {
            'make' => 'make_listing_option_id',
            'model' => 'model_listing_option_id',
            'condition' => 'condition_listing_option_id',
            'body_type' => 'body_type_listing_option_id',
            'transmission' => 'transmission_listing_option_id',
            'fuel_type' => 'fuel_type_listing_option_id',
            'drive' => 'drive_listing_option_id',
            'country' => 'country_listing_option_id',
            default => null,
        };
        if ($column === null) {
            return 0;
        }

        if ($categorySlug === 'model') {
            return Vehicle::query()->where('model_listing_option_id', $option->id)->count();
        }

        return Vehicle::query()->where($column, $option->id)->count();
    }
}
