$(document).ready(() => {
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
    });
});

