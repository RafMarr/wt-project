const resetFiltersButton = document.getElementById('resetFiltersBtn')
const priceFilter = document.getElementById('priceFilter')

resetFiltersButton.onclick = () => {
    priceFilter.value = "all"
    /* this instruction triggers the "change" event on priceFilter, in order to
       update the page content after filter reset */
    priceFilter.dispatchEvent(new Event('change'))
}
