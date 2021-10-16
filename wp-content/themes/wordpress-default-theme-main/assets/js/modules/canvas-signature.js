const UserSignature = function ( canvas_el ) {
  if ( !canvas_el ) {
    return;
  }

  this.canvas = canvas_el;
  this.initSize();

  this.ctx = this.canvas.getContext('2d');
  this.ctx.fillStyle = '#fff';
  // this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
  this.ctx.lineWidth = 5;
  this.ctx.strokeStyle = '#000';

  // this.x = 0;
  // this.y = 0;
  this.is_down = false;

  this.bindEvents();
};

UserSignature.prototype.bindEvents = function () {
  this.canvas.addEventListener('mousedown', e => {
    this.is_down = true;
    this.ctx.beginPath();
    this.x = e.pageX - this.getCoordinates().x - 3;
    this.y = e.pageY - this.getCoordinates().y + 16;
    this.ctx.moveTo(this.x, this.y);
  });

  this.canvas.addEventListener('mousemove', e => {
    if ( !this.is_down ) return;
    this.x = e.pageX - this.getCoordinates().x - 3;
    this.y = e.pageY - this.getCoordinates().y + 16;
    this.ctx.lineTo(this.x, this.y);
    this.ctx.stroke();
  });

  this.canvas.addEventListener('mouseup', e => {
    this.is_down = false;
    this.ctx.closePath();
  });

  // For phones
  this.canvas.addEventListener('touchstart', e => {
    this.is_down = true;
    this.ctx.beginPath();
    this.x = e.touches[0].pageX - this.getCoordinates().x;
    this.y = e.touches[0].pageY - this.getCoordinates().y;
    this.ctx.moveTo(this.x, this.y);
    blockBodyScroll();
  });
  this.canvas.addEventListener('touchmove', e => {
    if ( !this.is_down ) return;
    this.x = e.touches[0].pageX - this.getCoordinates().x;
    this.y = e.touches[0].pageY - this.getCoordinates().y;
    this.ctx.lineTo(this.x, this.y);
    this.ctx.stroke();
    // console.log(this.x, this.y);
  });
  this.canvas.addEventListener('touchend', e => {
    this.is_down = false;
    this.ctx.closePath();
    enableBodyScroll();
  });
}

UserSignature.prototype.clearCanvas = function () {
  this.ctx.fillStyle = '#fff';
  this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
}

UserSignature.prototype.canvasToImage = function ( result_image ) {
  result_image.src = canvas.toDataURL();
}

UserSignature.prototype.getCoordinates = function () {
  return {
    x: this.canvas.getBoundingClientRect().left + pageXOffset,
    y: this.canvas.getBoundingClientRect().top + pageYOffset,
  }
}

UserSignature.prototype.initSize = function () {
  this.canvas.width = parseInt( getComputedStyle(this.canvas).width.slice(0, -2) );
  this.canvas.height = parseInt( getComputedStyle(this.canvas).height.slice(0, -2) );
}

UserSignature.prototype.clear = function () {
  this.ctx.fillStyle = '#fff';
  this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
}

export default UserSignature;
