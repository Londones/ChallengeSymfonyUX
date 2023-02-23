let startPoint;
let offsetX;
let offsetY;
let element;
let userIdToSwipe, userName, otherImgsCarr, bottomTags, wrapper;
const imgClass = ['absolute', 'w-full', 'object-cover', 'drop-shadow-lg', 'rounded-lg'];
const carrClass = [ 'm-auto', 'mx-3', 'flex-none', 'w-16' ];
const imgCarrClass = [ 'w-full', 'object-cover', 'drop-shadow-lg', 'rounded-lg' ];
const tagsClass = [ 'h-10', 'px-6', 'font-semibold', 'bg-white/40', 'backdrop-blur-sm', 'rounded-full', 'text-slate-900'];
const like = document.querySelector('.like');
const pass = document.querySelector('.pass');
const fav = document.querySelector('.fav');

const isTouchDevice = () => {
    return (('ontouchstart' in window) ||
        (navigator.maxTouchPoints > 0) ||
        (navigator.msMaxTouchPoints > 0));
}

const listenToTouchEvents = () => {
    element.addEventListener('touchstart', (e) => {
        const touch = e.changedTouches[0];
        if (!touch) return;
        const { clientX, clientY } = touch;
        startPoint = { x: clientX, y: clientY }
        document.addEventListener('touchmove', handleTouchMove);
        element.style.transition = 'transform 0s';
    });

    document.addEventListener('touchend', handleTouchEnd);
    document.addEventListener('cancel', handleTouchEnd);

    like.addEventListener('click', () => {
        swipe(1)
    });
}

const listenToMouseEvents = () => {
    element.addEventListener('mousedown', (e) => {
        const { clientX, clientY } = e;
        startPoint = { x: clientX, y: clientY }
        document.addEventListener('mousemove', handleMouseMove);
        element.style.transition = 'transform 0s';
    });

    document.addEventListener('mouseup', handleMoveUp);

    // prevent card from being dragged
    element.addEventListener('dragstart', (e) => {
        e.preventDefault();
    });
}

const updateUser = (userId, mainImageUrl, user, otherImgs, tags) => {
    wrapper = document.querySelector('.card-wrapper');
    const card = document.querySelector('.card');
    const img = document.createElement('img');
    imgClass.forEach((c) => img.classList.add(c));
    card.appendChild(img);
    img.src = mainImageUrl;
    element = img;

    userName = document.querySelector('.userid');
    userName.innerHTML = user;

    otherImgsCarr = document.querySelector('.carr');
    otherImgs.forEach((img) => {
        const imgDiv = document.createElement('div');
        carrClass.forEach((c) => imgDiv.classList.add(c));
        const imgEl = document.createElement('img');
        imgCarrClass.forEach((c) => imgEl.classList.add(c));
        imgEl.src = img;
        imgDiv.appendChild(imgEl);
        otherImgsCarr.appendChild(imgDiv);
    });

    bottomTags = document.querySelector('.tags');
    tags.forEach((tag) => {
        const tagDiv = document.createElement('button');
        tagsClass.forEach((c) => tagDiv.classList.add(c));
        tagDiv.innerHTML = tag;
        bottomTags.appendChild(tagDiv);
    });

    if (isTouchDevice()) {
        listenToTouchEvents();
    } else {
        listenToMouseEvents();
    }
}

const handleMove = (x, y) => {
    offsetX = x - startPoint.x;
    offsetY = y - startPoint.y;
    const rotate = offsetX * 0.1;
    userName.style.opacity = 1 - Math.abs(offsetX) / 500;
    otherImgsCarr.style.opacity = 1 - Math.abs(offsetX) / 500;
    bottomTags.style.opacity = 1 - Math.abs(offsetX) / 500;
    element.style.transform = `translate(${offsetX}px, ${offsetY}px) rotate(${rotate}deg)`;
    // dismiss card
    if (Math.abs(offsetX) > element.clientWidth * 0.7) {
        swipe(offsetX > 0 ? 1 : -1);
    } else if (Math.abs(offsetY) > element.clientHeight * 0.7) {
        swipe(0);
    }
}

like.addEventListener('mouseup', () => swipe(1));
pass.addEventListener('mouseup', () => swipe(-1));
fav.addEventListener('mouseup', () => swipe(0));

// mouse event handlers
const handleMouseMove = (e) => {
    e.preventDefault();
    if (!startPoint) return;
    const { clientX, clientY } = e;
    handleMove(clientX, clientY);
}

const handleMoveUp = () => {
    startPoint = null;
    document.removeEventListener('mousemove', handleMouseMove);
    element.style.transform = '';
    userName.style.opacity = 1;
    otherImgsCarr.style.opacity = 1;
    bottomTags.style.opacity = 1;
}

// touch event handlers
const handleTouchMove = (e) => {
    if (!startPoint) return;
    const touch = e.changedTouches[0];
    if (!touch) return;
    const { clientX, clientY } = touch;
    handleMove(clientX, clientY);
}

const handleTouchEnd = () => {
    startPoint = null;
    document.removeEventListener('touchmove', handleTouchMove);
    element.style.transform = '';
    userName.style.opacity = 1;
    otherImgsCarr.style.opacity = 1;
    bottomTags.style.opacity = 1;
}

const swipe = (direction) => {
    startPoint = null;
    document.removeEventListener('mouseup', handleMoveUp);
    document.removeEventListener('mousemove', handleMouseMove);
    document.removeEventListener('touchend', handleTouchEnd);
    document.removeEventListener('touchmove', handleTouchMove);
    element.style.transition = 'transform 1s';
    if (direction === 0) {
        element.style.transform = `translate(${offsetX}px, ${- window.innerHeight}px) rotate(0deg)`;
    } else {
        element.style.transform = `translate(${direction * window.innerWidth}px, ${offsetY}px) rotate(${90 * direction}deg)`;
    }
    element.classList.add('dismissing');
    userName.style.opacity = 1;
    otherImgsCarr.style.opacity = 1;
    bottomTags.style.opacity = 1;

    let isSwipeRight = false
    let isFavorite = false
    
    if(direction === 1){
        isSwipeRight = true   
    } else if (direction === 0){
        isFavorite = true
    }

    fetch("/swipe/new", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
            "swippedId": userIdToSwipe,
            "isSwipeRight": isSwipeRight,
            "isFavorite": isFavorite
        }),
    })
    .then((response) => response.json())
    .then((data) => {
        const { isMatch, userName } = data
        console.log(isMatch)
        if(isMatch) {
            alert(`You matched with ${userName} !`)
        }
    })

    setTimeout(() => {
        element.remove();
        userName.innerHTML = '';
        otherImgsCarr.innerHTML = '';
        bottomTags.innerHTML = '';
        nextUser();
    }, 500);
}


const nextUser = () => {
    fetch("/swipe/next")
    .then((response) => response.json())
    .then((data) => {
        const { user } = data
        userIdToSwipe = user.id

        updateUser(
            user.id,
            user.imageUrl ? `/images/users/${user.imageUrl}` : "https://png.pngtree.com/png-clipart/20210608/ourlarge/pngtree-dark-gray-simple-avatar-png-image_3418404.jpg",
            user.name,
            [
                'https://picsum.photos/400/600',
                'https://picsum.photos/400/600',
                'https://picsum.photos/400/600',
                'https://picsum.photos/400/600',
            ],
            user.categories
        )
    })
}

nextUser();
