(function($) {
    function newTabGallerySearch() {
        const baseQueryUrl = "https://search.newtabgallery.com/search.php";
        const searchQuery = {
            qt: $("#search-input").val(),
        };

        $.ajax({
            type: "POST",
            url: baseQueryUrl,
            data: searchQuery,
            dataType: "JSON",
            success: postResults,
        });
    }

    function generateListing(listing) {
        return "<div class='listing'>" + 
            "<a href='" + listing.clickurl + "'><h3 class='title'>" + listing.title + "</h3></a>" + 
            "<p class='display-url'>" + listing.displayurl + "</p>" + 
            "<p class='description'>" + listing.description + "</p>" + 
            "</div>";
    }

    function generateAd(ad) {
        return "<div class='listing ad'>" + 
            "<a id='" + ad.adId + "' href='" + ad.clickurl + "'><h3 class='title'>" + ad.title + "</h3></a>" +
            "<p class='display-url'>" + ad.displayurl + "</p>" +
            "<p class='description'>" + ad.description + "</p>" +
            "<img class='hidden-impression' src='" + ad.impressionurl + "' width='1' height='1' border='0' />" +
            "</div>";
    }

    function postResults(response) {
        const webListings = response.weblistings && response.weblistings.weblisting ? response.weblistings.weblisting : [];
        const adListings = response.adlistings && response.adlistings.listing ? response.adlistings.listing : [];

        $("body").addClass("search-complete");
        $("#web-listings").empty();

        adListings.forEach(ad => $("#web-listings").append(generateAd(ad)));
        webListings.forEach(listing => $("#web-listings").append(generateListing(listing)));
    }

    function onReady(){
        $(".masthead").addClass("background-" + Math.floor(Math.random() * 5 + 1));

        $("#search-submit").on('click', () => {
            newTabGallerySearch();
        });

        $("#search-form").on('submit', (form) => {
            form.preventDefault();
            newTabGallerySearch();
        })
    }

    $(document).ready(onReady);
})(jQuery);