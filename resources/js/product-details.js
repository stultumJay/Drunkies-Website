$(document).ready(function() {
    // Submit filter forms on checkbox change
    $('#brand-filter-form input, #category-filter-form input').on('change', function() {
        // Combine both forms and submit as GET
        let brands = $('#brand-filter-form input:checked').map(function(){ return this.value; }).get();
        let categories = $('#category-filter-form input:checked').map(function(){ return this.value; }).get();
        let sort = $('#sort').val();
        let params = [];
        if (brands.length) params.push('brands[]=' + brands.join('&brands[]='));
        if (categories.length) params.push('categories[]=' + categories.join('&categories[]='));
        if (sort) params.push('sort=' + sort);
        let url = window.location.pathname + (params.length ? '?' + params.join('&') : '');
        window.location.href = url;
    });
    // Submit sort form on change
    $('#sort').on('change', function() {
        $('#brand-filter-form input, #category-filter-form input').first().trigger('change');
    });
}); 