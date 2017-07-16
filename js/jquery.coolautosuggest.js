/**
 * jQuery Plugin for creating AJAX auto-suggest textfield
 * @requires jQuery 1.4 or later
 *
 * Copyright (c) 2017 Lucky
 * Licensed under the GPL license:
 *   http://www.gnu.org/licenses/gpl.html
 */

(function($) {
  function autosuggest(settings, txtField){
    var divId=settings.divId;
    var hovered=false;
    var arrData=null;

    var textField=txtField;

    var timer;
    var mouseStopped = true;

    textField.after('<div class="' + settings.divClass + '" id="' + divId + '"></div>');
    textField.attr("autocomplete", "off");

    var holder=textField.next("#" + divId);
    holder.hide();

    // Default width is textfield width + 3px
    if (settings.width == null) {
      settings.width = textField.width() + 3;
    }

    // Prevent ENTER default action if needed.
    if(settings.idField!=null || settings.submitOnSelect==true || settings.preventEnter==true){
      textField.keypress(
        function(e){
          if(e.keyCode==13){
            return false;
          }

          return true;
        }
      );
    }

    var currRow=0;
    var suggestRow=settings.rowIdPrefix;
    var suggestItem=settings.rowClass;
    var suggestText=settings.rowTextClass;
    var additionalFields = "";

    var me=this;
    textField.keyup(
      function(e){
        if($.inArray(e.keyCode, [37, 38, 39, 40, 13, 9, 16, 17, 18]) == -1){
          if($(this).val().length>=settings.minChars){
            additionalFields = "";
            if (typeof settings.additionalFields == "object") {
              for (var key in settings.additionalFields){
                additionalFields = additionalFields + key + encodeURI(settings.additionalFields[key].val());
              }
            }

            $.ajax({
              url:settings.url + encodeURI($(this).val()) + additionalFields,
              beforeSend : function(){
                if(typeof settings.onRequest === "function"){
                  settings.onRequest.call();
                }
              },
              complete : function(){
                if(typeof settings.onComplete === "function"){
                  settings.onComplete.call();
                }
              },
              success:function(data){
                try{
                  if (typeof data == "string")
                    arrData=$.parseJSON(data);
                  else if (typeof data == "object")
                    arrData=data;

                  var arr=arrData;
                  var html="";

                  currRow=0;

                  if(arr==null){
                    me.hide();
                  }
                  else{
                    if(arr.length>0){
                      for(i=0;i<arr.length;i++){
                        cssClass=suggestItem;

                        var template=settings.template;
                        if(i%2!=0) {
                          cssClass+=" even";
                        }
                        else {
                          cssClass+=" odd";
                        }

                        if(i==0){
                          cssClass+=" first";
                        }
                        if(i==(arr.length-1)){
                          cssClass+=" last";
                        }

                        template=template.replace(/\[rowClass\]/g, cssClass);

                        var id_field="";
                        if(settings.idField!=null){
                          id_field=arr[i].id;
                        }

                        template=template.replace(/\[id_field\]/g, id_field);

                        var style="";
                        var thumbClass="";
                        if(settings.showThumbnail==true){
                          if(arr[i].thumbnail!=undefined){
                            style='background-image:url(' + arr[i].thumbnail + ');';
                            thumbClass=settings.rowThumbnailClass;
                          }
                        }

                        template=template.replace(/\[style\]/g, style);
                        template=template.replace(/\[thumbnailClass\]/g, thumbClass);

                        var desc="";
                        var descClass="";
                        if(settings.showDescription==true){
                          if(arr[i].description!=undefined){
                            descClass=settings.rowDescriptionClass;
                            desc=arr[i].description;
                          }
                        }

                        template=template.replace(/\[descriptionClass\]/g, descClass);
                        template=template.replace(/\[description\]/g, desc);

                        template=template.replace(/\[rowId\]/g, suggestRow + (i+1));
                        template=template.replace(/\[seq_id\]/g, i);
                        template=template.replace(/\[textClass\]/g, suggestText);
                        template=template.replace(/\[text\]/g, arr[i].data.replace(new RegExp('(' + escapeRegExp(textField.val()) + ')', 'gi'), "<b>$1</b>"));

                        html+=template;
                      }

                      holder.html(html);

                      for(i=1;i<=arr.length;i++){
                        var target=holder.find("#" + suggestRow + i);
                        target.bind('touchstart touchend', function(e) {
                            hovered=false;
                            me.unSelectAll(this);
                            var t = $(this);
                            highlight(t);
                            autoSubmit();
                        });

                        target.mouseover(function(e){
                          if (mouseStopped == false) {
                            hovered=true;
                            me.unSelectAll(this);
                            var t = $(this);
                            highlight(t);
                          }
                        });

                        target.mouseout(function(e){
                          hovered=false;
                          me.unSelectAll(this);
                        });

                        target.click(function(e){
                          var t = $(this);
                          highlight(t);

                          // Callback function
                          if(typeof settings.onSelected == "function"){
                            settings.onSelected.call(this, arrData[t.attr("seq_id")]);
                          }

                          autoSubmit();

                          me.hide();
                        });

                        target.mousemove(function(e){
                          mouseStopped = false;
                          clearTimeout(timer);
                          timer = setTimeout(mouseStop, 200);
                        });
                      }

                      me.show(holder.find("." + suggestItem).height() * arr.length);
                    }
                    else{
                      me.hide();
                    }
                  }
                }
                catch(e){
                  if(typeof settings.onError === "function"){
                    settings.onError.call();
                  }
                }
              },
              error: function(xhr, status, ex){
                if(typeof settings.onError === "function"){
                  settings.onError.call();
                }
              }
            });
          }
          else{
            me.hide();
          }
        }
        else{
          if(holder.css("display")!="none"){
            checkKey(e);
          }
        }
      }
    );

    textField.bind(
      "blur",
      function(e){
        if(settings.idField!=null){
          if(me.checkSelected(textField.val())==false){
            textField.val("");
            settings.idField.val("");
          }
        }

        if(hovered==false){
          me.hide();
        }
        else{
          hovered=false;
        }

        if(typeof settings.onSelected == "function" && currRow>0){
          settings.onSelected.call(this, arrData[currRow-1]);
          me.hide();
        }
      }
    );

    $(document).scroll(function(e) {
      positionHolder();
    });

    this.show=function(height){
      positionHolder();

      holder.css({
        "height":height + "px",
        "width":settings.width + "px"
      });

      holder.find("." + suggestItem).css({
        "width":settings.width + "px",
        "overflow":"hidden"
      });

      holder.show();
    }

    this.hide=function(){
      holder.hide();
    }

    this.unSelectAll=function(div){
      var id=$(div).attr("id");
      var rows=holder.find("." + suggestItem).get().length;

      for(i=1;i<=rows;i++){
        holder.find("#" + suggestRow + i).removeClass("selected");
      }

      currRow=parseInt(id.replace(suggestRow, ""));
      var rgx=/^[0-9]+$/;
      if(!rgx.test(currRow)){
        currRow=0;
      }
    }

    this.checkSelected=function(data){
      if(arrData!=null){
        for(var i=0;i<arrData.length;i++){
          if(arrData[i].data==data){
            return true;
          }
        }
      }

      return false;
    }

    function checkKey(e){
      if(holder.css("display")!="none"){
        var rows=holder.find("." + suggestItem).get().length;
        if(e.keyCode==40){
          currRow++;
          if(currRow<=rows){
            var target=holder.find("#" + suggestRow + currRow);
            me.unSelectAll(target);

            highlight(target);
          }
          else{
            currRow=rows;
          }
        }
        else if(e.keyCode==38){
          currRow--;
          if(currRow>0){
            var target=holder.find("#" + suggestRow + currRow);
            me.unSelectAll(target);

            highlight(target);
          }
          else{
            currRow=1;
          }
        }
        else if(e.keyCode==13){
          if(settings.idField!=null){
            if(me.checkSelected(textField.val())==false){
              textField.val("");
              settings.idField.val("");
            }
          }

          // Callback function
          if(typeof settings.onSelected == "function"){
            if(currRow>0){
              settings.onSelected.call(this, arrData[currRow-1]);
            }
            else{
              settings.onSelected.call(this, null);
            }
          }

          me.hide();
        }
      }
      else{
        // Callback function
        if(typeof settings.onSelected == "function"){
          settings.onSelected.call(this, null);
        }
      }

      return true;
    }

    function escapeRegExp(str) {
      return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    }

    function highlight(obj, e) {
      obj.addClass("selected");
      textField.val(obj.find("." + suggestText).text());
      if(settings.idField!=null){
        settings.idField.val(obj.attr("id_field"));
      }
    }

    function autoSubmit() {
      if(settings.submitOnSelect==true){
        $("form").has(textField).submit();
      }
    }

    function mouseStop(){
      mouseStopped = true;
    }

    function positionHolder() {
      holder.css({
        "position":"fixed",
        "left":(textField.offset().left - $(document).scrollLeft()) + "px",
        "top":(textField.offset().top + textField.height() + 5 - $(document).scrollTop()) + "px"
      });
    }
  }

  $.fn.coolautosuggest = function(options) {
    var settings = {
      url : null,
      width : null,
      minChars : 1,
      idField : null,
      submitOnSelect : false,
      showThumbnail : false,
      showDescription : false,
      onSelected : null,
      onError : function () {
        alert("Sorry, an error has occured!");
      },
      onRequest : null,
      onComplete : null,
      preventEnter : false,
      additionalFields : [],
      divId : "suggestions_holder",
      divClass : "suggestions",
      rowIdPrefix : "suggest_row",
      rowClass : "suggest_item",
      rowTextClass : "suggestion_title",
      rowThumbnailClass : "thumbnail",
      rowDescriptionClass : "description",
      template: '<div id="[rowId]" class="[rowClass]" id_field="[id_field]" seq_id="[seq_id]" >' +
          '<div class="[thumbnailClass]" style="[style]"></div>' +
          '<div class="[textClass]">[text]</div>' +
          '<div class="[descriptionClass]">[description]</div>' +
        '</div>'
    };
    $.extend(settings, options);

    return this.each(function() {
      var obj = new autosuggest(settings, $(this));
    });
  }
})(jQuery);
