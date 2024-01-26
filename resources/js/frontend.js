function scrollToBottom() {
    let chatContent = $('.fp__chat_body');
    chatContent.scrollTop(chatContent.prop('scrollHeight'));
}


window.Echo.private('chat.' + loggedInUserId)
    .listen('ChatEvent', (e) => {
        console.log(e);
        let html = `
            <div class="fp__chating">
                <div class="fp__chating_img">
                    <img src="${e.avatar}" style='border-radius:50%;'>
                </div>
                <div class="fp__chating_text">
                    <p>${e.message}</p>
                </div>
            </div>
    `;

        $('.fp__chat_body').append(html);

        scrollToBottom();

    });
