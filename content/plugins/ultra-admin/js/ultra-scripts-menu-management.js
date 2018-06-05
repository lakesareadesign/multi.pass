/**
 * @Package: WordPress Plugin
 * @Subpackage: Ultra WordPress Admin Theme
 * @Since: Ultra 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of Ultra WordPress Admin Theme Plugin.
 */


jQuery(function($) {

    'use strict';

    var ULTRA_MENUMNG_SETTINGS = window.ULTRA_MENUMNG_SETTINGS || {};

    

    ULTRA_MENUMNG_SETTINGS.iconPanel = function(e) {

      $('.ultraicon').click(function(e) {
        e.stopPropagation();
        var panel = $(this).parent().find(".ultraiconpanel");
        var iconstr = $(".ultraicons").html();
        panel.html("");
        panel.append(iconstr);
        panel.show();
      });


    };




    ULTRA_MENUMNG_SETTINGS.menuToggle = function() {

      $('.ultratoggle').click(function(e) {

        var id = $(this).parent().attr("data-id");

        if($(this).hasClass("plus")) {
          $(this).removeClass("plus dashicons-plus").addClass("minus dashicons-minus");
          //$(this).html("-");
          $(this).parent().parent().find(".ultramenupanel").removeClass("closed").addClass("opened");
        } else if($(this).hasClass("minus")) {
          $(this).removeClass("minus dashicons-minus").addClass("plus dashicons-plus");
          //$(this).html("+");
          $(this).parent().parent().find(".ultramenupanel").removeClass("opened").addClass("closed");
        }

      });


      $('.ultrasubtoggle').click(function(e) {

        var id = $(this).parent().attr("data-id");

        if($(this).hasClass("plus")) {
          $(this).removeClass("plus dashicons-plus").addClass("minus dashicons-minus");
          //$(this).html("-");
          $(this).parent().parent().find(".ultrasubmenupanel").removeClass("closed").addClass("opened");
        } else if($(this).hasClass("minus")) {
          $(this).removeClass("minus dashicons-minus").addClass("plus dashicons-plus");
          //$(this).html("+");
          $(this).parent().parent().find(".ultrasubmenupanel").removeClass("opened").addClass("closed");
        }

      });


    };

    ULTRA_MENUMNG_SETTINGS.saveMenu = function() {

      $('#ultra-savemenu').click(function(e) {

          var neworder = "";
          var newsuborder = "";
          var menurename = "";
          var submenurename = "";
          var menudisable = "";
          var submenudisable = "";

          $(".ultramenu").each(function(){
                    var id = $(this).attr("data-id");
                    var menuid = $(this).attr("data-menu-id");
                    neworder += menuid+"|";
                    if($(this).hasClass("disabled")){
                      menudisable += menuid+"|";
                    }
          });

          $(".ultrasubmenu").each(function(){
                    var id = $(this).attr("data-id");
                    var parentpage = $(this).attr("data-parent-page");
                    newsuborder += parentpage+":"+id+"|";
                    if($(this).hasClass("disabled")){
                      submenudisable += parentpage+":"+id+"|";
                    }
          });

          $(".ultra-menurename").each(function(){
                    var id = $(this).attr("data-id");
                    var sid = $(this).attr("data-menu-id");
                    var val = $(this).attr("value");
                    var icon = $(this).parent().parent().find(".ultra-menuicon").attr("value");
                    //console.log(icon);
                    menurename += id+":"+sid+"@!@%@"+val+"[$!&!$]"+icon+"|#$%*|";
          });


          $(".ultra-submenurename").each(function(){
                    var id = $(this).attr("data-id");
                    var parent = $(this).attr("data-parent-id");
                    var parentpage = $(this).attr("data-parent-page");
                    var val = $(this).attr("value");
                    submenurename += parentpage+"[($&)]"+parent+":"+id+"@!@%@"+val+"|#$%*|";
          });


          //console.log(neworder);
          //console.log(menurename);

            var action = 'ultra_savemenu';
            var data = {
                neworder: neworder,
                newsuborder: newsuborder,
                menurename: menurename,
                submenurename: submenurename,
                menudisable: menudisable,
                submenudisable: submenudisable,
                action: action,
                ultra_nonce: ultra_vars.ultra_nonce
            };

        $.post(ajaxurl, data, function(response) {
             //console.log(response);
             location.reload();
            //console.log(response);
        });

        return false;

        });

    };


    ULTRA_MENUMNG_SETTINGS.resetMenu = function() {

      $('#ultra-resetmenu').click(function(e) {

            var action = 'ultra_resetmenu';
            var data = {
                action: action,
                ultra_nonce: ultra_vars.ultra_nonce
            };

        $.post(ajaxurl, data, function(response) {
             location.reload();
            //console.log(response);
        });

        return false;

        });

    };






    ULTRA_MENUMNG_SETTINGS.menuDisplay = function() {

      $('.ultradisplay, .ultrasubdisplay').click(function(e) {

        //var id = $(this).parent().attr("data-id");

        if($(this).hasClass("disable")) {
          $(this).removeClass("disable").addClass("enable");
          //$(this).html("show");
          $(this).parent().parent().removeClass("enabled").addClass("disabled");
        } else if($(this).hasClass("enable")) {
          $(this).removeClass("enable").addClass("disable");
          //$(this).html("hide");
          $(this).parent().parent().removeClass("disabled").addClass("enabled");
        }

      });

    };










    /******************************
     initialize respective scripts 
     *****************************/
    $(document).ready(function() {
       // ULTRA_MENUMNG_SETTINGS.menuResizer();
      //  ULTRA_MENUMNG_SETTINGS.menuClickResize();
      //  ULTRA_MENUMNG_SETTINGS.logoURL();
        ULTRA_MENUMNG_SETTINGS.menuToggle();
        ULTRA_MENUMNG_SETTINGS.saveMenu();
        ULTRA_MENUMNG_SETTINGS.menuDisplay();
        ULTRA_MENUMNG_SETTINGS.iconPanel();
        ULTRA_MENUMNG_SETTINGS.resetMenu();

    });

    $(window).resize(function() {
     //   ULTRA_MENUMNG_SETTINGS.menuResizer();
     //   ULTRA_MENUMNG_SETTINGS.menuClickResize();
    });

    $(window).load(function() {
     //   ULTRA_MENUMNG_SETTINGS.menuResizer();
      //  ULTRA_MENUMNG_SETTINGS.menuClickResize();
    });

});


jQuery(function($) {
    if($.isFunction($.fn.sortable)){
        $( "#ultra-enabled, #ultra-disabled" ).sortable({
          connectWith: ".ultra-connectedSortable",
          handle: ".ultramenu-wrap",
          cancel: ".ultratoggle",
          placeholder: "ui-state-highlight",
        }).disableSelection();
      }
  });


jQuery(function($) {
    if($.isFunction($.fn.sortable)){
      $( ".ultrasubmenu-wrap" ).sortable({
        placeholder: "ui-state-highlight",
      }).disableSelection();
  }
  });


jQuery(function($) {
  $(document).ready(function(){
    $(document).on('click', ".pickicon", function () {
          var clss = $(this).attr("data-class");
          var prnt = $(this).parent().parent();
          //console.log(clss);
          prnt.find("input").attr("value",clss);
          prnt.find("input").val(clss);
          var main = prnt.find(".ultramenuicon");
          main.removeClass(main.attr("data-class")).addClass(clss);
          main.attr("data-class",clss);
          return false;
      });

    $(document).on('click', "body", function () {
          $(".ultraiconpanel").hide();
          //return false;
      });




    });
});
