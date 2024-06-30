$(document).ready(function () {
    // Initialize the wizard
    $("#wizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slide",
        stepsOrientation: "horizontal",
        titleTemplate: '<span class="number">#index#</span>',
        onInit: function (event, currentIndex) {
            // Get the value of the #SessionExists input
            var sessionExists = $("#SessionExists").val();

            // Show or hide the buttons based on session value on page load
            if (currentIndex == 0 && sessionExists == 1) {
                $("#wizard").find(".actions [href='#next']").show();
                $("#wizard").find(".actions [href='#previous']").show();
            }
    
            // Existing code for hiding "Next" button conditionally
            if (currentIndex == 0 && sessionExists != 1) {
                $("#wizard").find(".actions [href='#next']").hide();
                $("#wizard").find(".actions [href='#previous']").hide();
            }
        },
        onStepChanged: function (event, currentIndex, newIndex) {

            if (currentIndex === 0 && sessionExists !== 1) {
                $(".actions [href='#next']").hide();
            } else {
                $(".actions [href='#next']").show();
            }

            return true;
        },
        onFinished: function (event, currentIndex) {

            $("#wizard").find(".actions a[href='#finish']").hide();

        }
    });
});