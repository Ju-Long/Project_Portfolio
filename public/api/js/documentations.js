$(document).ready(() => {
    const js1 = "#gist109788689";
    const js2 = "#gist109788665";
    const js3 = "#gist109788676";
    const js4 = "#gist109788683";
    const js5 = "#gist109788672";
    const js6 = "#gist109788854";
    const php1 = "#gist109788457";
    const php2 = "#gist109788719";
    const php3 = "#gist109788725";
    const php4 = "#gist109788731";
    const php5 = "#gist109788744";
    const php6 = "#gist109788888";

    $(".select-trigger i").click(() => {
        $(".select-trigger i").removeClass();
        if ($(".select-wrapper").hasClass('active')) {
            $(".select-wrapper").removeClass('active');
            $(".select-trigger i").addClass('fa-solid');
        } else {
            $(".select-wrapper").addClass('active');
            $(".select-trigger i").addClass('fa-regular');
        }
        $(".select-trigger i").addClass('fa-sort-down');
    });

    $(".option").click((e) => {
        $(".option.selected").removeClass('selected');
        $(`.option#${e.target.id}`).addClass('selected');
        $(".select-trigger span").text(e.target.id);
        $(".select-wrapper").removeClass('active');
        $(".select-trigger i").removeClass();
        $(".select-trigger i").addClass('fa-solid');
        $(".select-trigger i").addClass('fa-sort-down');
        displaycode();
    });

    $(".codes-lang").click((e) => {
        $(".codes-lang .active").removeClass('active');
        let id = e.target.id;
        $(`.codes-lang #${id}`).addClass('active');
        displaycode();
    });

    const displaycode = () => {
        $(".gist").hide();
        let lang = $(".codes-lang .active").attr('id');
        let type = $(".option.selected").attr('id');
        if (type === "get_nearest_bus_stop" && lang === "php")
            $(`.gist${php1}`).show();
        else if (type === "get_nearest_bus_stop" && lang === "js")
            $(`.gist${js1}`).show();
        else if (type === "get_bus_arrival_time" && lang === "php")
            $(`.gist${php2}`).show();
        else if (type === "get_bus_arrival_time" && lang === "js")
            $(`.gist${js2}`).show();
        else if (type === "get_bus_route" && lang === "php")
            $(`.gist${php3}`).show();
        else if (type === "get_bus_route" && lang === "js")
            $(`.gist${js3}`).show();
        else if (type === "get_bus_stop_data" && lang === "php")
            $(`.gist${php4}`).show();
        else if (type === "get_bus_stop_data" && lang === "js")
            $(`.gist${js4}`).show();
        else if (type === "get_bus_data" && lang === "php")
            $(`.gist${php5}`).show();
        else if (type === "get_bus_data" && lang === "js")
            $(`.gist${js5}`).show();
        else if (type === "get_random_quote" && lang === "php")
            $(`.gist${php6}`).show();
        else if (type === "get_random_quote" && lang === "js")
            $(`.gist${js6}`).show();

    }
    displaycode()
});

{
    /* <code class="lang lang-js">
    <code class="syntax">const </code><code class="name">userdata </code><code class="operator">= </code><code class="bracket">{</code><code class="name">username</code><code class="operator">: </code><code class="replace">$_your_username</code><code class="operator">, </code><code class="name">accountkey</code><code class="operator">: </code><code class="replace">$_your_account_key</code><code class="bracket">}</code>

    <code class="comment">//fetch</code>

    <code class="operator">fetch</code><code class="bracket">(</code><code class="string">`</code><code class="string">https://babasama.com/api/get_nearest_bus_stop/</code>
    </code>  */
}