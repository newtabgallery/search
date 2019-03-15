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

    function getLocation(href) {
        var l = document.createElement("a");
        l.href = href;
        return l;
    };

    function newTabGallerySearch() {
        const queryHost = "https://search.newtabgallery.com";
        const baseQueryUrl = `${queryHost}/search.php`;
        const baseVigilinkQueryUrl = `${queryHost}/search-vigilink.php`;
        const searchTerms = $("#search-input").val();

        const searchQuery = {
            qt: searchTerms,
        };

        searchResults = $.ajax({
            type: "POST",
            async: false,
            url: baseQueryUrl,
            data: searchQuery,
            dataType: "JSON"
        });

        vigilinkSearchResults = $.ajax({
            type: "POST",
            async: false,
            url: baseVigilinkQueryUrl,
            data: searchQuery,
            dataType: "JSON"
        });

        postResults(searchResults.responseJSON, vigilinkSearchResults.responseJSON);

        updateURL(searchTerms);
    }

    function generateListing(listing) {
        const baseResultHost = getLocation(`https://${listing.displayurl}`).hostname;

        return `<div class='listing'>
                <a href='${listing.clickurl}'><h3 class='title'>${listing.title}</h3></a>
                <a href='${listing.clickurl}' class="display-url-link">
                    <p class='display-url'>${listing.displayurl}</p>
                </a>
                <p class='description'>${listing.description}</p>
            </div>`;
    }

    function generateAd(ad) {
        const baseAdHost = getLocation(`https://${ad.displayurl}`).hostname;

        return `<div class='listing ad'>
                <a id='${ad.adId}' href='${ad.clickurl}'><h3 class='title'>${ad.title}</h3></a>
                <a id='${ad.adId}' href='${ad.clickurl}' class="display-url-link">
                    <p class='display-url'><span class='marketplace-label'>Ad</span>${ad.displayurl}</p>
                </a>
                <p class='description'>${ad.description}</p>
                <img class='hidden-impression' src='${ad.impressionurl}' width='1' height='1' border='0' />
            </div>`;
    }

    function generateVigilinkCarousel(vigilinkMetadata) {
        const carouselData = vigilinkMetadata[0];
        if (carouselData && carouselData.links.length > 0) {
            let carouselOutput = `<div class="vigilink-product-list row row-eq-height">`;
            carouselData.links.forEach(link => {
                carouselOutput += `<div class="col-sm">
                    <div class="card">
                        <a class="product-link" href="${link.url}">
                            <div class="product-image" style="background-image: url(${link.imageUrl});"></div>
                            <div>
                                ${link.product}
                            </div>
                        </a>
                    </div>
                </div>`;
            });
            carouselOutput += `</div>`;
            return carouselOutput;
        }
    }

    function postResults(response, vigilinkResponse) {
        const webListings = response.weblistings && response.weblistings.weblisting ? response.weblistings.weblisting : [];
        const adListings = response.adlistings && response.adlistings.listing ? response.adlistings.listing : [];
        const vigilinkMetadata = vigilinkResponse && vigilinkResponse.items ? vigilinkResponse.items : [];

        $("body").addClass("search-complete");
        $("#web-listings").empty();

        adCount = adListings.length;
        if (adCount > 0) {
            firstAds = adListings.slice(0, adCount/2).forEach(ad => $("#web-listings").append(generateAd(ad)));;
            $("#web-listings").append(generateVigilinkCarousel(vigilinkMetadata));
            secondAds = adListings.slice(adCount/2, adCount - 1).forEach(ad => $("#web-listings").append(generateAd(ad)));
        } else {
            $("#web-listings").append(generateVigilinkCarousel(vigilinkMetadata));
        }

        webListings.forEach(listing => $("#web-listings").append(generateListing(listing)));
    }

    function onReady(){
        if ($.urlParam(SEARCH_NAME) != "") {
            $("#search-input").val(decodeURIComponent($.urlParam(SEARCH_NAME)).replace(/\+/g, " "));
            newTabGallerySearch();
        }

        $("#search-form").on('submit', (form) => {
            form.preventDefault();
            newTabGallerySearch();
        });

        backgroundCount = window.NEWTABGALLERY_BACKGROUND_COUNT !== undefined ? NEWTABGALLERY_BACKGROUND_COUNT : 5;
        $(".masthead").addClass("background-" + (Math.floor(Math.random() * backgroundCount) + 1));
        $("body").addClass("loaded");
    }

    $(document).ready(onReady);
})(jQuery);