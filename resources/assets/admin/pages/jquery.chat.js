/**
* Theme: Ubold Admin Template
* Author: Coderthemes
* Chat application 
*/

!function($) {
    "use strict";

    var ChatApp = function() {
        this.$body = $("body"),
        this.$chatInput = $('.chat-input'),
        this.$chatList = $('.conversation-list'),
        this.$chatSendBtn = $('.chat-send .btn')
    };

    //saves chat entry - You should send ajax call to server in order to save chat enrty
    ChatApp.prototype.save = function() {
        var $this = this;
        var chatText = this.$chatInput.val();
        var chatTimeDay = moment().format("DD-MM-YYYY");
        var chatTimeHour = moment().format("hh:mm:s");
        var chatTime = $('<div class="text-center"></div>');
        chatTime.append($('<div></div>').html(chatTimeDay));
        chatTime.append($('<div></div>').html(chatTimeHour));
        
        if (chatText == "") {
            sweetAlert("Oops...", "You forgot to enter your chat message", "error");
            this.$chatInput.focus();
        } else {
            $this.$chatSendBtn.prop("disabled",true);
            $.ajax({
                type: 'post',
                url: urlReply,
                data : {
                    "_token"   : window.Laravel.csrfToken,
                    'body' : chatText,
                },
                success: function(response){
                    $this.$chatSendBtn.prop("disabled",false);
                    if(response.status == "NG"){
                        sweetAlert("Oops...", "Some error have been detected on the server. Please try again later.", "error");
                        return;
                    }
                    $('<li class="clearfix odd"><div class="chat-avatar"><img class="avatar-chat" src="'+ avatar +'">' + $("<div>").append(chatTime).html() + '</div><div class="conversation-text"><div class="ctext-wrap"><i>'+ username +'</i><p>' + chatText + '</p></div></div></li>').appendTo('.conversation-list');
                    $this.$chatInput.val('');
                    $this.$chatInput.focus();
                    $this.$chatList.scrollTo('100%', '100%', {
                        easing: 'swing'
                    });
                },
                error: function(jqXHR, exception) {
                    sweetAlert("Oops...", "Some error have been detected on the server. Please try again later.", "error");
                    $this.$chatSendBtn.prop("disabled",false);
                }       
            });

            
        }
    },
    ChatApp.prototype.init = function () {
        var $this = this;
        //binding keypress event on chat input box - on enter we are adding the chat into chat list - 
        $this.$chatInput.keypress(function (ev) {
            var p = ev.which;
            if (p == 13) {
                $this.save();
                return false;
            }
        });


        //binding send button click
        $this.$chatSendBtn.click(function (ev) {
           $this.save();
           return false;
        });
    },
    //init ChatApp
    $.ChatApp = new ChatApp, $.ChatApp.Constructor = ChatApp
    
}(window.jQuery),

//initializing main application module
function($) {
    "use strict";
    $.ChatApp.init();
}(window.jQuery);