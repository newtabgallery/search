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

    function generateListing(listing, vigilinkMetadata) {
        const baseResultHost = getLocation(`https://${listing.displayurl}`).hostname;
        const cardData = vigilinkMetadata.find(metaData => baseResultHost.indexOf(metaData.name.toLowerCase()) != -1);

        return `<div class='listing ${cardData ? 'card' : ''}'>
                <a href='${listing.clickurl}'><h3 class='title'>${listing.title}</h3></a>
                <a href='${listing.clickurl}' class="display-url-link">
                    <p class='display-url'>${listing.displayurl}</p>
                </a>
                <p class='description'>${listing.description}</p>
                ${cardData ? generateCardFooter(cardData) : ''}
            </div>`;
    }

    function generateAd(ad, vigilinkMetadata) {
        const baseAdHost = getLocation(`https://${ad.displayurl}`).hostname;
        const cardData = vigilinkMetadata.find(metaData => baseAdHost.indexOf(metaData.name.toLowerCase()) != -1);

        return `<div class='listing ad ${cardData ? 'card' : ''}'>
                <a id='${ad.adId}' href='${ad.clickurl}'><h3 class='title'>${ad.title}</h3></a>
                <a id='${ad.adId}' href='${ad.clickurl}' class="display-url-link">
                    <p class='display-url'><span class='marketplace-label'>Ad</span>${ad.displayurl}</p>
                </a>
                <p class='description'>${ad.description}</p>
                <img class='hidden-impression' src='${ad.impressionurl}' width='1' height='1' border='0' />
                ${cardData ? generateCardFooter(cardData) : ''}
            </div>`;
    }

    function generateCardFooter(cardData) {
        let cardFooterHTML = `<div class="card-footer"><strong>Popular Links:</strong> `;
        cardData.links.forEach(link => cardFooterHTML += `<a class="product-link" href="${link.url}">${link.product}</a><span class="product-divider"></span>`);
        cardFooterHTML += `<span class="sponsored">Sponsored: Links provided by VigLink</span>`
        cardFooterHTML += `<div>`
        return cardFooterHTML;
    }

    function postResults(response, vigilinkResponse) {
        const webListings = response.weblistings && response.weblistings.weblisting ? response.weblistings.weblisting : [];
        const adListings = response.adlistings && response.adlistings.listing ? response.adlistings.listing : [];
        const vigilinkMetadata = vigilinkResponse.items ? vigilinkResponse.items : [];

        $("body").addClass("search-complete");
        $("#web-listings").empty();

        adListings.forEach(ad => $("#web-listings").append(generateAd(ad, vigilinkMetadata)));
        webListings.forEach(listing => $("#web-listings").append(generateListing(listing, vigilinkMetadata)));
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

        $(".masthead").addClass("background-" + Math.floor(Math.random() * 5 + 1));
    }

    $(document).ready(onReady);
})(jQuery);