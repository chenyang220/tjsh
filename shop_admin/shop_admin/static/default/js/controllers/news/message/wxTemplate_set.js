//设置消息模板
$(function ()
{
    $('#mail_form').validator({
        ignore: ':hidden',
        theme: 'yellow_bottom',
        timely: 1,
        stopOnError: true,
        fields: {
            //'icp_number': 'required;email;'
        },
        valid: function (form)
        {
            parent.$.dialog.confirm('确认更改此消息模板？', function ()
                {
                    Public.ajaxPost(SITE_URL + '?ctl=News_WxMessage&met=editTemplateMail&typ=json', $("#mail_form").serialize(), function (data)
                    {   
                        if (data.status == 200)
                        {
							parent.Public.tips({content: '编辑成功！'});
                            var callback = frameElement.api.data.callback;
                            callback();
                            
                        }
                        else
                        {
                            parent.Public.tips({type: 1, content: data.msg || '操作无法成功，请稍后重试！'});
                        }

                       
                    });
                });
        },
    }).on("click", "a.submit-btn", function (e)
    {
        $(e.delegateTarget).trigger("validate");
    });

});
