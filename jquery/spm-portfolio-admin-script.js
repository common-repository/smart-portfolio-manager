jQuery(function($) {
    var application_type = $('#application_portfolio_type :selected').val();
    if(application_type=="application"){
        $("#portfolio_website_url").hide();
        $("#spmpcl_app_portfolio").show();
        $("#spmpcl_ios_portfolio").show();
    }else if(application_type=="website"){
        $("#portfolio_website_url").show();
        $("#spmpcl_app_portfolio").hide();
        $("#spmpcl_ios_portfolio").hide();
    }
});

function HandleProfilioType(value) {
    if(value=="application"){
        $("#portfolio_website_url").hide();
        $("#spmpcl_app_portfolio").show();
        $("#spmpcl_ios_portfolio").show();
    }else if(value=="website"){
        $("#portfolio_website_url").show();
        $("#spmpcl_app_portfolio").hide();
        $("#spmpcl_ios_portfolio").hide();
    }
}