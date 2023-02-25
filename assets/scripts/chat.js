const receiver = document.getElementById("receveid-messages");
const messageForm = document.getElementById("message-form");
const messageInput = document.getElementById("message-input");
const sendButton = document.getElementById("send-message-button");
const messageList = document.getElementById("message-list");
const isEmpty = document.getElementById("empty");
const anchor = document.getElementById("anchor");

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

    const messageDate = new Date(date.date)

    if (isEmpty) isEmpty.style.display = "none"

    if (user.id === connectedUserId) {
        anchor.insertAdjacentHTML("beforebegin",`
            <div class="self flex flex-col items-end">
                <div class="border-violet-700 bg-white border-2 p-4 my-2 mr-4 rounded-3xl">
                    <p class="message-content mb-2">${content}</p>
                    <p class="message-date text-xs">${formatDate(messageDate)}</p>
                </div>
            </div>
        `)
    } else {
        anchor.insertAdjacentHTML("beforebegin", `
            <div class="other flex flex-col items-start">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white p-4 my-2 ml-4 rounded-3xl">
                    <p class="message-content mb-2">${content}</p>
                    <p class="message-date text-xs">${formatDate(messageDate)}</p>
                </div>
            </div>
        `)
    }
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
