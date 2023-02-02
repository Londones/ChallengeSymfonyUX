//const _receiver = document.getElementById('mercure-content-receiver');
//const _messageInput = document.getElementById('mercure-message-input');
//const _sendForm = document.getElementById('mercure-message-form');

//const sendMessage = (message) => {
  //if (message === '') {
    //return;
  //}

  //fetch(_sendForm.action, {
    //method: _sendForm.method,
    //body: 'message=' + message,
    //headers: new Headers({
      //'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
    //})
  //}).then(() => {
    //_messageInput.value = '';
  //});
//};

//_sendForm.onsubmit = (evt) => {
  //sendMessage(_messageInput.value);

  //evt.preventDefault();
  //return false;
//};

//const url = new URL(mercurePublicUrl);
//url.searchParams.append('topic', '/messages');
//const eventSource = new EventSource(url, { withCredentials: true });
//eventSource.onmessage = (evt) => {
  //const data = JSON.parse(evt.data);
  //if (!data.message) {
    //return;
  //}
  //_receiver.insertAdjacentHTML('beforeend', `<div class="message">${data.message}</div>`);
//};


const pingButton = document.getElementById("ping")
pingButton.addEventListener("click", ping)
async function ping () {
    const response = await fetch('/chat/ping', {
        method: 'POST',
    });

    if (response.ok) {
        console.log('Ping sent successfully');
    } else {
        console.error('Error sending ping');
    }
}


const url = new URL(mercurePublicUrl);
url.searchParams.append('topic', 'http://monsite.com/ping');
const eventSource = new EventSource(url);
eventSource.onmessage = (evt) => {
    console.log("new event")
};

