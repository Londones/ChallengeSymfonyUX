let startPoint;
let offsetX;
let offsetY;
let element;
let userName, description, otherImgsCarr, bottomTags, wrapper;
const imgClass = ['absolute', 'w-full', 'object-cover', 'drop-shadow-lg', 'rounded-lg'];
const carrClass = [ 'm-auto', 'mx-3', 'flex-none', 'w-16' ];
const imgCarrClass = [ 'w-full', 'object-cover', 'drop-shadow-lg', 'rounded-lg' ];
const tagsClass = [ 'h-10', 'px-6', 'font-semibold', 'bg-white/40', 'backdrop-blur-sm', 'rounded-full', 'text-slate-900'];
const like = document.querySelector('.like');
const pass = document.querySelector('.pass');
const fav = document.querySelector('.fav');

const dummyData = {
  mainImageUrl: 'https://picsum.photos/400/600',
  user: 'John Doe',
  desc: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nunc ut aliquam ultricies, nunc nisl aliquam nisl, eget aliquam nunc nisl eu nunc. Sed euismod, nunc ut aliquam ultricies, nunc nisl aliquam nisl, eget aliquam nunc nisl eu nunc.',
  otherImgs: [
    'https://picsum.photos/400/600',
    'https://picsum.photos/400/600',
    'https://picsum.photos/400/600',
    'https://picsum.photos/400/600',
  ],
  tags: [
    '#Tag',
    '#Tag',
    '#Tag',
  ]
}

const dummyData2 = {
  mainImageUrl: 'https://loremflickr.com/400/600',
  user: 'Jane Doe',
  desc: 'Sed euismod, nunc ut aliquam ultricies, nunc nisl aliquam nisl, eget aliquam nunc nisl eu nunc. Sed euismod, nunc ut aliquam ultricies, nunc nisl aliquam nisl, eget aliquam nunc nisl eu nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
  otherImgs: [
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
    'https://loremflickr.com/400/600',
  ],
  tags: [
    'Tag 1',
    'Tag 2',
    'Tag 3',
    'Tag 4',
  ]
}

let count = 0;

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
      dismiss(1)
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

  like.addEventListener('mouseup', () => {
    dismiss(1)
  });
  // prevent card from being dragged
  element.addEventListener('dragstart', (e) => {
    e.preventDefault();
  });
}

const init = (mainImageUrl, user, desc, otherImgs, tags) => {
  wrapper = document.querySelector('.card-wrapper');
  const card = document.querySelector('.card');
  const img = document.createElement('img');
  imgClass.forEach((c) => img.classList.add(c));
  card.appendChild(img);
  img.src = mainImageUrl;
  element = img;

  userName = document.querySelector('.userid');
  userName.innerHTML = user;

  description = document.querySelector('.desc');
  description.innerHTML = desc;

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
  description.style.opacity = 1 - Math.abs(offsetX) / 500;
  otherImgsCarr.style.opacity = 1 - Math.abs(offsetX) / 500;
  bottomTags.style.opacity = 1 - Math.abs(offsetX) / 500;
  element.style.transform = `translate(${offsetX}px, ${offsetY}px) rotate(${rotate}deg)`;
  // dismiss card
  if (Math.abs(offsetX) > element.clientWidth * 0.7) {
    dismiss(offsetX > 0 ? 1 : -1);
  } else if (Math.abs(offsetY) > element.clientHeight * 0.7) {
    dismiss(0);
  }
}

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
  description.style.opacity = 1;
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
  description.style.opacity = 1;
  otherImgsCarr.style.opacity = 1;
  bottomTags.style.opacity = 1;
}

const dismiss = (direction) => {
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
  description.style.opacity = 1;
  otherImgsCarr.style.opacity = 1;
  bottomTags.style.opacity = 1;
  setTimeout(() => {
    element.remove();
    userName.innerHTML = '';
    description.innerHTML = '';
    otherImgsCarr.innerHTML = '';
    bottomTags.innerHTML = '';
    next();
  }, 100);
}


// change to the next dummy data when the card is swiped
const next = () => {
  if (count % 2 === 0) {
    init(dummyData.mainImageUrl, dummyData.user, dummyData.desc, dummyData.otherImgs, dummyData.tags);
  } else {
    init(dummyData2.mainImageUrl, dummyData2.user, dummyData2.desc, dummyData2.otherImgs, dummyData2.tags);
  }
  count++;
}

next();