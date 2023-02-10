const receiver = document.getElementById("receveid-messages");
const messageInput = document.getElementById("message-input");
const sendButton = document.getElementById("send-message-button");

const sendMessage = () => {
    const messageContent = messageInput.value

    if (!messageContent) return;

    fetch(msgSendUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "content": messageContent,
            "channelId": channelId
        }),
    }).then(() => {
        messageInput.value = "";
    })
};

sendButton.addEventListener("click", sendMessage)

const url = new URL(mercurePublicUrl);
url.searchParams.append("topic", "/messages/channel/" + channelId);

const eventSource = new EventSource(url);

eventSource.onmessage = (event) => {
    const data = JSON.parse(event.data);
    console.log(data)
    receiver.insertAdjacentHTML('beforeend', `<div class="message">${data.content}</div>`);
};
