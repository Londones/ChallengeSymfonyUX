const receiver = document.getElementById("receveid-messages");
const messageForm = document.getElementById("message-form");
const messageInput = document.getElementById("message-input");
const sendButton = document.getElementById("send-message-button");
const messageList = document.getElementById("message-list");
const isEmpty = document.getElementById("empty");

const sendMessage = (event) => {
    event.preventDefault()
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

messageForm.addEventListener("submit", sendMessage);

const url = new URL(mercurePublicUrl);
url.searchParams.append("topic", "/messages/channel/" + channelId);

const eventSource = new EventSource(url);

eventSource.onmessage = (event) => {
    const data = JSON.parse(event.data);
    const { user, date, content } = data.message

    const elementClass = user.id === connectedUserId ? "self" : "other" 
    const messageDate = new Date(date.date)

    if (isEmpty) isEmpty.style.display = "none"

    messageList.insertAdjacentHTML('beforeend', `
        <div class="${elementClass}">
            <p class="message-content">${content}</p>
            <p class="message-date">${formatDate(messageDate)}</p>
        </div>
    `);
};

function formatDate(date) {
    const formatUnit = (unit) => unit < 10 ? `0${unit}` : `${unit}`

    const day = formatUnit(date.getDate())
    const month = formatUnit(date.getMonth() + 1)
    const year = date.getFullYear()
    const hours = formatUnit(date.getHours())
    const minutes = formatUnit(date.getMinutes())

    return `${day}/${month}/${year} - ${hours}:${minutes}`
}
