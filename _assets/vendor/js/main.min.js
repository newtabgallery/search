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

    function getBingAdSearchResults(searchQuery) {
        return new Promise(function(resolve) {
            let bingSearch = new BCISearch({
                pid: 1208,
                query: searchQuery,
                count: 6,
                subid: 7100
            });
            bingSearch.getResults(function(results) {
                resolve(results);
            });
        })
      }

    function newTabGallerySearch() {
        const queryHost = "https://search.newtabgallery.com";
        const baseQueryUrl = `${queryHost}/search.php`;
        const baseVigilinkQueryUrl = `${queryHost}/search-vigilink.php`;
        const searchTerms = $("#search-input").val();

        const searchQuery = {
            qt: searchTerms,
        };

        $("#bing-ads-first").empty();
        $("#vigilink-ads").empty();
        $("#bing-ads-second").empty();
        $("#adm-search-results").empty();
        $("#adm-ads").empty();

        let searchResults = $.ajax({
            type: "POST",
            async: false,
            url: baseQueryUrl,
            data: searchQuery,
            dataType: "JSON",
            success: function (data, textStatus, xhr) {
                const webListings = data.weblistings && data.weblistings.weblisting ? data.weblistings.weblisting : [];
                const admAdListings = data.adlistings && data.adlistings.listing ? data.adlistings.listing : [];

                webListings.forEach(listing => $("#adm-search-results").append(generateListing(listing)));
                admAdListings.forEach(ad => $("#adm-ads").append(generateAdmAd(ad)));;
            }
        });

        let bingSearch = new BCISearch({
            pid: 1208,
            query: searchTerms,
            count: 6,
            subid: 7100
        }).getResults(function(results) {
            const bingAdListings = results ? results : [];

            bingAdCount = bingAdListings.length;
            if (bingAdCount > 0) {
                $("#bing-ads-first").append(generateMicrosoftPrivacyRow(true));
                firstAds = bingAdListings.slice(0, bingAdCount/2).forEach(ad => $("#bing-ads-first").append(generateBingAd(ad)));;
                secondAds = bingAdListings.slice(bingAdCount/2, bingAdCount - 1).forEach(ad => $("#bing-ads-second").append(generateBingAd(ad)));
                $("#bing-ads-second").append(generateMicrosoftPrivacyRow());
            }

            let vigilinkSearchResults = $.ajax({
                type: "POST",
                async: false,
                url: baseVigilinkQueryUrl,
                data: searchQuery,
                dataType: "JSON",
                success: function (data, textStatus, xhr) {
                    const vigilinkMetadata = data && data.items ? data.items : [];
                    $("#vigilink-ads").append(generateVigilinkCarousel(vigilinkMetadata));
                }
            });
        });

        updateURL(searchTerms);

        $("body").addClass("search-complete");
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

    function generateMicrosoftPrivacyRow(showAdRelated) {
        return `<div class='privacy-row row'>
                    <div class="col text-left" style="${!!showAdRelated ? '' : 'display: none;'}">
                        <p>Ads related to: <strong>${$("#search-input").val()}</strong></p>
                    </div>
                    <div class="col text-right">
                        <a href='https://privacy.microsoft.com/en-us/privacystatement' target="_blank">Ads by Microsoft (privacy)</a>
                    </div>
                </div>`;
    }

    function generateBingAd(ad) {
        return `<div class='listing ad'>
                <a id='${ad.adId}' href='${ad.link}'><h3 class='title'>${ad.title}</h3></a>
                <a id='${ad.adId}' href='${ad.link}' class="display-url-link">
                    <p class='display-url'><span class='marketplace-label'>Ad</span>${ad.domain}</p>
                </a>
                <p class='description'>${ad.text}</p>
            </div>`;
    }

    function generateAdmAd(ad) {
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
            carouselOutput += `<span class="sponsored">Product suggestions provided by Vigilink.</span>`;
            return carouselOutput;
        }
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