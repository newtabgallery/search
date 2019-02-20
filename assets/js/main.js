(function($) {
    const SEARCH_NAME = 'q';

    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                          .exec(window.location.href);
        if (results == null) {
             return 0;
        }
        return results[1] || 0;
    }
    
    function updateURL(searchParams) {
        if (history.pushState) {
            var newurl = window.location.protocol + "//" + 
                window.location.host +
                window.location.pathname +
                "?" + SEARCH_NAME + "=" + encodeURIComponent(searchParams);
            window.history.pushState({ path:newurl }, '', newurl);
        }
    }

    function newTabGallerySearch() {
        const baseQueryUrl = "https://search.newtabgallery.com/search.php";
        const searchTerms = $("#search-input").val();

        const searchQuery = {
            qt: searchTerms,
        };

        $.ajax({
            type: "POST",
            url: baseQueryUrl,
            data: searchQuery,
            dataType: "JSON",
            success: postResults,
        });

        window.localStorage.setItem("search-input", searchTerms);
        updateURL(searchTerms);
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
            "<p class='display-url'><span class='marketplace-label'>Ad</span>" + ad.displayurl + "</p>" +
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

        window.localStorage.setItem("web-listings", $("#web-listings").html());
    }

    function onBackButtonNavigation(){
        if(window.localStorage.getItem("web-listings") != null){
            $("#web-listings").html(window.localStorage.getItem("web-listings"));
        }

        if(window.localStorage.getItem("search-input") != null){
            $("#search-input").val(window.localStorage.getItem("search-input"));
        }
    }

    function onReady(){
        if ($.urlParam(SEARCH_NAME)) {
            $("#search-input").val(decodeURIComponent($.urlParam(SEARCH_NAME)));
            newTabGallerySearch();
        }

        if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
            onBackButtonNavigation();
        }

        $("#search-submit").on('click', () => {
            newTabGallerySearch();
        });

        $("#search-form").on('submit', (form) => {
            form.preventDefault();
            newTabGallerySearch();
        });

        $(".masthead").addClass("background-" + Math.floor(Math.random() * 5 + 1));
    }

    $(document).ready(onReady);
})(jQuery);