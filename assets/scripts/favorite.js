const likeButtons = document.getElementsByClassName("like")

for (let likeButton of likeButtons){
    likeButton.addEventListener("click", () => {
        const userId = likeButton.getAttribute("data-id")

        fetch("/swipe/update", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "swippedId": userId,
            }),
        })
        .then((response) => response.json())
        .then((data) => {
            const { isMatch, userName } = data
            if(isMatch) {
                alert(`vous avez matché avec: ${userName} !`)
            } else {
                alert(`Un match sera crée si ${userName} like votre profil !`)
            }
            window.location.reload()
        })
    })
}
