jQuery(document).ready(function(e) {
    function f() {
        var e = [];
        for (var t in u) e[t] = 'a[href$=".' + u[t] + '"]';
        a = e.join(",");
    }
    function l(t) {
        e.ajax({
            url: ESDC_JS.ajax_url,
            data: t,
            success: function(n) {
                t.action === "esdc_search_dates" ? e("#esdc-search-results").html(n) : t.action === "esdc_addtocount";
            }
        });
    }
    var t = e("#esdc_time_from"), n = e("#esdc_time_to"), r = e(".nav-tab"), i = e("#tabbed"), s = e("#searchfield"), o = s.find("#esdc-search"), u = e.parseJSON(ESDC_JS.tracked), a = "";
    f();
    e(a).click(function(t) {
        t.preventDefault();
        var n = e(this)[0].pathname.split("/"), r = n[n.length - 1];
        payload = {
            action: "esdc_addtocount",
            filename: r,
            cnonce: ESDC_JS.count_nonce
        };
        l(payload);
        t.target.target === "_blank" ? window.open(t.target.href) : t.target.target === "" && (window.location = t.target.href);
    });
    t.datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(e, t) {
            t.id === "esdc_time_from" && n.datepicker("option", "minDate", e);
        }
    });
    n.datepicker({
        dateFormat: "yy-mm-dd"
    });
    r.click(function() {
        var t = "." + e(this).attr("id");
        i.find(".esdc-container").removeClass("active");
        r.removeClass("nav-tab-active");
        e(this).addClass("nav-tab-active");
        i.find(t).addClass("active");
    });
    o.click(function() {
        var e = s.find("#esdc_time_from").val(), r = s.find("#esdc_time_to").val(), i = {
            action: "esdc_search_dates",
            from: t.val(),
            to: n.val(),
            snonce: ESDC_JS.ds_nonce
        };
        l(i);
    });
});