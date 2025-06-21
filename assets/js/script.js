(()=>{var e;(e=jQuery)(document).ready((()=>{function s(s){const o=e(s).data("ev-cat"),l=e(s).data("ev-act"),i=e(s).data("ev-label");gtag("event",l,{event_category:o,event_label:i})}e(".article-collection-item").click((()=>{e(".article-collection-wrap").hide(),e(".article-fea-collection-wrap").addClass("show"),e(".article-fea-collection-carousel").slick({slidesToShow:3,nav:!0,prevArrow:e(".fea-prev"),nextArrow:e(".fea-next"),infinite:!1,responsive:[{breakpoint:991,settings:{slidesToShow:2}},{breakpoint:575,settings:{slidesToShow:1}}]})})),e("#closeArticleFeaCollection").click((()=>{e(".article-collection-wrap").show(),e(".article-fea-collection-wrap").removeClass("show")})),e(".article-collection-carousel").slick({slidesToShow:6,nav:!0,prevArrow:e(".prev"),nextArrow:e(".next"),infinite:!1,responsive:[{breakpoint:991,settings:{slidesToShow:2}},{breakpoint:575,settings:{slidesToShow:1}}]}),e(".header-menu").click((()=>{e(".header-collapse").slideToggle()})),e(".search-menu").click((()=>{e(".search-collapse").slideDown(),e(".header-collapse").slideUp(),e("body").addClass("stop-scroll")})),e(".btn-search-close").click((()=>{e(".search-collapse").slideUp(),e("body").removeClass("stop-scroll")})),e(".header-menu").click((()=>{e(".menu-overlay").toggleClass("active"),e(".menu-button").toggleClass("open")})),e(".menu-overlay").click((()=>{e(".header-collapse").slideUp(),e(".menu-overlay").removeClass("active"),e(".menu-button").removeClass("open")})),e(".tabs-menu li a.tab-item").click((({target:s})=>{const o="active-tab-menu",l=s.dataset.tab;return e(".tabs-menu li a").removeClass(o),s.classList.add(o),e(".tabs-content .tabs").removeClass("active first-tab"),e(`.${l}`).addClass("active"),!1})),e(".btn-navbar-close").click((function(){e(this).parent().removeClass("active")})),e(window).scroll((({target:s})=>{const o=e(s);o.scrollTop()>120?e(".brand-header").addClass("hide-header"):e(".brand-header").removeClass("hide-header"),o.scrollTop()>120?e(".channel-header").addClass("show"):e(".channel-header").removeClass("show"),o.scrollTop()>120?e(".main-logo").addClass("hide-logo"):e(".main-logo").removeClass("hide-logo")})),setInterval((()=>{const s=e("#brand-logo .show"),o=s.next().length?s.next():s.siblings().first();s.hide().removeClass("show"),o.fadeIn("slow").addClass("show")}),[3e3]),e(".article-share").click((s=>{s.preventDefault(),e(".social-share-list").slideToggle()})),e("#article-sponsor-list").slick({dots:!1,infinite:!0,speed:300,autoplay:!0,slidesToShow:2,slidesToScroll:1,arrows:!0,responsive:[{breakpoint:1199,settings:{slidesToShow:1,slidesToScroll:1,infinite:!0}},{breakpoint:600,settings:{slidesToShow:1,slidesToScroll:1}},{breakpoint:480,settings:{slidesToShow:1,slidesToScroll:1}}]}),e("#channel-sponsor-list").slick({dots:!1,infinite:!0,speed:300,autoplay:!0,slidesToShow:5,slidesToScroll:1,arrows:!0,responsive:[{breakpoint:1024,settings:{slidesToShow:3,slidesToScroll:1,infinite:!0}},{breakpoint:600,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:480,settings:{slidesToShow:1,slidesToScroll:1}}]}),e(".topic-header-list-wrapper").slick({dots:!1,infinite:!0,speed:300,slidesToShow:1,variableWidth:!0}),

// e("body").find("[data-ev-cat]").each(((o,l)=>{let i,a="click",t=!1;"ontouchend"in document==1&&(a="click touchend"),e(l).on(a,(e=>{!0!==i&&("touchend"===e.type?(s(l),t=!0):"click"!==e.type||t?t=!1:s(l))})).on("touchmove",(()=>{i=!0})).on("touchstart",(()=>{i=!1}))})),

e("a, .subscription_id_link").each(((s,o)=>{let l=o;if("A"!==e(o).prop("nodeName")&&([l]=e("a",o)),!l||null===l)return;if(!e(o).hasClass("subscription_id_link")&&(void 0===l.attributes.href||-1===l.attributes.href.value.indexOf("/cancel-subscription")))return;const i=new URLSearchParams(window.location.search);if(!i.has("subscription_id"))return;const a=i.get("subscription_id");let t=e(l).attr("href");t=-1===t.indexOf("?")?`${t}?subscription_id=${a}`:`${t}&subscription_id=${a}`,t=t.replace("{subscription_id}",a);const n=i.get("item_id");null!=n&&(t=t.replace("{item_id}",n)),void 0!==ajaxurl.nonce&&(t+=`&_wpnonce=${ajaxurl.nonce}`),void 0!==ajaxurl.wcsnonce&&(t+=`&_wcsnonce=${ajaxurl.wcsnonce}`),e(l).attr("href",t)}))}))})();





(async function () {
  const parser = new UAParser();
  const result = parser.getResult();

  const sessionId = sessionStorage.getItem("session_id") || (() => {
    const id = crypto.randomUUID();
    sessionStorage.setItem("session_id", id);
    return id;
  })();

  const geo = await fetch("https://ipapi.co/json/").then(res => res.json()).catch(() => ({}));

  const data = {
    session_id: sessionId,
    user_agent: navigator.userAgent,
    device_model: result.device.model || '',
    device_vendor: result.device.vendor || '',
    device_type: result.device.type || '',
    os: result.os.name + " " + result.os.version,
    browser: result.browser.name + " " + result.browser.version,
    gender: '', // populate this based on user interaction or form input if available
    latitude: geo.latitude || null,
    longitude: geo.longitude || null,
    city: geo.city || '',
    region: geo.region || '',
    country: geo.country_name || '',
    user_type: 'guest',
    referrer: document.referrer,
    query_string: window.location.search,
    entry_page: sessionStorage.getItem('entry_page') || window.location.href,
    exit_page: window.location.href,
    visited_urls: window.location.href,
    start_time: sessionStorage.getItem("start_time") || new Date().toISOString(),
    end_time: new Date().toISOString()
  };

  sessionStorage.setItem("entry_page", data.entry_page);
  sessionStorage.setItem("start_time", data.start_time);

  navigator.sendBeacon("/../../track/session.php", JSON.stringify(data));
})();
