{{-- Same GET params as inventory listing — dynamic options from approved vehicles --}}
<div class="filter stm-vc-ajax-filter">
  <form method="get" action="{{ route('inventory.index') }}" class="home-inventory-search-form">
    @include('pages.partials.inventory-filters-fields', [
      'filters' => $filters ?? [],
      'filterOptions' => $filterOptions ?? [],
      'submitLabel' => 'Search',
      'useSearchIcon' => true,
    ])
  </form>
</div>
