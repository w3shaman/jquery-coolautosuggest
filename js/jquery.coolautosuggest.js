/**
 * jQuery Plugin for creating AJAX auto-suggest textfield
 * @requires jQuery 1.4 or later
 *
 * Copyright (c) 2016 Lucky
 * Licensed under the GPL license:
 *   http://www.gnu.org/licenses/gpl.html
 */

(function($) {
  function autosuggest(settings, textField){
    this.divId="suggestions_holder";
    this.hovered=false;
    this.arrData=null;

    this.textField=textField;

    this.textField.after('<div class="suggestions" id="' + this.divId + '"></div>');
    this.textField.attr("autocomplete", "off");

    this.holder=this.textField.next("#" + this.divId);
    this.holder.hide();

    // Prevent ENTER default action if needed.
    if(settings.idField!=null || settings.submitOnSelect==true || settings.preventEnter==true){
      this.textField.keypress(
        function(e){
          if(e.keyCode==13){
            return false;
          }

          return true;
        }
      );
    }

    var currRow=0;
    var suggestRow="suggest_row";
    var suggestItem="suggest_item";
    var additionalFields = "";

    var me=this;
    this.textField.keyup(
      function(e){
        if(e.keyCode!=37 && e.keyCode!=38 && e.keyCode!=39 && e.keyCode!=40 && e.keyCode!=13){
          if($(this).val().length>=settings.minChars){
            additionalFields = "";
            if (typeof settings.additionalFields == "object") {
              for (var key in settings.additionalFields){
                additionalFields = additionalFields + key + encodeURI(settings.additionalFields[key].val());
              }
            }

            $.ajax({
              url:settings.url + encodeURI($(this).val()) + additionalFields,
              success:function(data){
                try{
                  if (typeof data == 'string')
                    me.arrData=$.parseJSON(data);
                  else if (typeof data == 'object')
                    me.arrData=data;

                  var arr=me.arrData;
                  var html="";

                  currRow=0;

                  if(arr==null){
                    me.hide();
                  }
                  else{
                    if(arr.length>0){
                      for(i=0;i<arr.length;i++){
                        cssClass=suggestItem;

                        if(i==0){
                          cssClass+=" first";
                        }
                        if(i==(arr.length-1)){
                          cssClass+=" last";
                        }

                        var id_field='';
                        if(settings.idField!=null){
                          id_field=' id_field="' + arr[i].id + '"';
                        }

                        var thumb="";
                        if(settings.thumbnail==true){
                          var style="";
                          if(arr[i].thumbnail!=undefined){
                            style=' style="background-image:url(' + arr[i].thumbnail + ');"';
                          }
                          thumb='<div class="thumbnail"' + style + '></div>';
                        }

                        var desc="";
                        if(settings.description==true){
                          if(arr[i].description!=undefined){
                            desc='<div class="description">' + arr[i].description + '</div>';
                          }
                        }

                        html+='<div id="' + suggestRow + (i+1) + '" class="' + cssClass + '"' + id_field + ' seq_id="' + i + '" >' + thumb + '<div class="suggestion_title">' + arr[i].data.replace(new RegExp('(' + me.textField.val() + ')', 'gi'), "<b>$1</b>") + '</div>' + desc + '</div>';
                      }

                      me.holder.html(html);

                      for(i=1;i<=arr.length;i++){
                        var target=me.holder.find("#" + suggestRow + i);
                        target.mouseover(function(e){
                          me.hovered=true;
                          me.unSelectAll(this);
                          $(this).addClass("selected");
                        });

                        target.mouseout(function(e){
                          me.hovered=false;
                          $(this).removeClass("selected");
                        });

                        target.click(function(e){
                          me.textField.val($(this).find(".suggestion_title").text());
                          if(settings.idField!=null){
                            settings.idField.val($(this).attr("id_field"));
                          }

                          // Callback function
                          if(typeof settings.onSelected == "function"){
                            settings.onSelected.call(this, me.arrData[$(this).attr("seq_id")]);
                          }

                          if(settings.submitOnSelect==true){
                            $("form").has(me.textField).submit();
                          }

                          me.hide();
                        });
                      }

                      me.show(me.holder.find("." + suggestItem).height() * arr.length);
                    }
                    else{
                      me.hide();
                    }
                  }
                }
                catch(e){
                  alert('Sorry, an error has occured!');
                }
              },
              error: function(xhr, status, ex){
                alert('Sorry, an error has occured!');
              }
            });
          }
          else{
            me.hide();
          }
        }
        else{
          if(me.holder.css("display")!="none"){
            checkKey(e);
          }
          else{
            // Callback function
            if(typeof settings.onSelected == "function"){
              settings.onSelected.call(this, null);
            }
          }
        }
      }
    );

    this.textField.bind(
      "blur",
      function(e){
        if(settings.idField!=null){
          if(me.checkSelected(me.textField.val())==false){
            me.textField.val("");
            settings.idField.val("");
          }
        }

        if(me.hovered==false){
          me.hide();
        }
        else{
          me.hovered=false;
        }
      }
    );

    this.show=function(height){
      this.holder.css({
        "position":"absolute",
        "left":this.textField.position().left + "px",
        "top":this.textField.position().top + this.textField.height() + 5 + "px",
        "height":height + "px"
      });

      this.holder.css({
        "width":settings.width + "px"
      });

      this.holder.find("." + suggestItem).css({
        "width":settings.width + "px",
        "overflow":"hidden"
      });

      this.holder.show();
    }

    this.hide=function(){
      this.holder.hide();
    }

    this.unSelectAll=function(div){
      var id=$(div).attr("id");
      var rows=this.holder.find("." + suggestItem).get().length;

      for(i=1;i<=rows;i++){
        this.holder.find("#" + suggestRow + i).removeClass("selected");
      }

      currRow=parseInt(id.replace(suggestRow, ""));
      var rgx=/^[0-9]+$/;
      if(!rgx.test(currRow)){
        currRow=0;
      }
    }

    this.checkSelected=function(data){
      if(this.arrData!=null){
        for(var i=0;i<this.arrData.length;i++){
          if(this.arrData[i].data==data){
            return true;
          }
        }
      }

      return false;
    }

    function checkKey(e){
      if(me.holder.css("display")!="none"){
        var rows=me.holder.find("." + suggestItem).get().length;
        if(e.keyCode==40){
          currRow++;
          if(currRow<=rows){
            if(currRow>0){
              me.holder.find("#" + suggestRow + (currRow-1)).removeClass("selected");
            }

            var target=me.holder.find("#" + suggestRow + currRow);

            target.addClass("selected");
            me.textField.val(target.find(".suggestion_title").text());
            if(settings.idField!=null){
              settings.idField.val(target.attr("id_field"));
            }
          }
          else{
            currRow=rows;
          }
        }
        else if(e.keyCode==38){
          currRow--;
          if(currRow>0){
            if(currRow<rows){
              me.holder.find("#" + suggestRow + (currRow+1)).removeClass("selected");
            }

            var target=me.holder.find("#" + suggestRow + currRow);

            target.addClass("selected");
            me.textField.val(target.find(".suggestion_title").text());
            if(settings.idField!=null){
              settings.idField.val(target.attr("id_field"));
            }
          }
          else{
            currRow=1;
          }
        }
        else if(e.keyCode==13){
          if(settings.idField!=null){
            if(me.checkSelected(me.textField.val())==false){
              me.textField.val("");
              settings.idField.val("");
            }
          }

          // Callback function
          if(typeof settings.onSelected == "function"){
            if(currRow>0){
              settings.onSelected.call(this, me.arrData[currRow-1]);
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
  }

  $.fn.coolautosuggest = function(options) {
    var textfield = $(this);
    var settings = {
      url : null,
      width : textfield.width() + 3,
      minChars : 1,
      idField : null,
      submitOnSelect : false,
      showThumbnail : false,
      showDescription : false,
      onSelected : null,
      preventEnter : false,
      additionalFields : []
    };
    $.extend(settings, options);

    return this.each(function() {
      var obj = new autosuggest(settings, textfield);
    });
  }
})(jQuery);
