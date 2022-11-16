self.addEventListener('message', _ => {
    fetch('/get-unread-message')
    .then(ee=>ee.json())
    .then(res=>postMessage(res));
})
