/*global jQuery*/
'use strict';

function Meme(imgPath) {
    // Private properties
    var canvas = document.getElementById('meme-image'),
        context = canvas.getContext('2d'),
        memeImage = new Image(),
        imgWidth = 100,
        imgHeight = 100,
        textOffsetAmount = 30,
        topTextArr = [],
        bottomTextArr = [],
        whiteColorInput = document.getElementById('text-color-white'),
    // Private method declarations
        setDimensions,
        clearCanvas,
        initImageMeme,
        drawImage,
        setTextOptions,
        drawText,
        blockEvent,
        handleImageDrop;
    
    // Public properties
    this.fullpath = imgPath || '';
    
    // Private methods
    setDimensions = (function (width, height) {
        imgWidth = width;
        imgHeight = height;
    }).bind(this);//end setDimensions()
    
    clearCanvas = (function () {
        context.clearRect(0, 0, imgWidth, imgHeight);
    }).bind(this);//end clearCanvas()
    
    initImageMeme = (function () {
        var self = this;
        memeImage.src = this.fullpath;
        memeImage.onload = function () {
            setDimensions(memeImage.width, memeImage.height);
            self.refresh();
        }
    }).bind(this);//end initImageMeme()
    
    drawImage = (function () {
        canvas.width = imgWidth;
        canvas.height = imgHeight;
        if (this.fullpath) {
            context.drawImage(memeImage, 0, 0, imgWidth, imgHeight);
        }//end if
    }).bind(this);//end drawImage()
    
    setTextOptions = (function () {
        var textColor = (whiteColorInput.checked) ? 'white' : 'black',
            strokeColor = (whiteColorInput.checked) ? 'black' : 'white';
        
        context.fillStyle = textColor;
        context.strokeStyle = strokeColor;
        context.lineWidth = 1.5;
        context.font = 'normal 30px Impact';
        context.textAlign = 'center';
    }).bind(this);//end setTextOptions()
    
    drawText = (function (textArray, top) {
        var checkText = '',
            displayText = '',
            canvasWidth = canvas.width,
            textHeight,
            textWidth,
            word,
            displayArray = [],
            i = 0;
        
        for (i; i < textArray.length; i++) {
            word = textArray[i];
            
            checkText = displayText + word + ' ';
            textWidth = context.measureText(checkText).width;
            
            if (textWidth > canvasWidth) {
                displayArray.push(displayText);
                displayText = word + ' ';
            } else {
                displayText = checkText;
            }
        }//end for
        displayArray.push(displayText);
        
        for (i = 0; i < displayArray.length; i++) {
            textHeight = (top)
                ? textOffsetAmount * (i + 1)
                : canvas.height - Math.floor(textOffsetAmount / 4) -
                    (textOffsetAmount * (displayArray.length - 1)) + (textOffsetAmount * i);
            
            context.fillText(displayArray[i], canvasWidth / 2, textHeight);
            context.strokeText(displayArray[i], canvasWidth / 2, textHeight);
        }//end for
    }).bind(this);//end drawText()
    
    blockEvent = (function (event) {
        event.preventDefault();
        event.stopPropagation();
    }).bind(this);//end blockEvent()
    
    handleImageDrop = (function (event) {
        var imageSource,
            imageReader,
            self = this;
        
        event.preventDefault();
        imageSource = event.dataTransfer.files;
        
        if (imageSource.length > 0 && imageSource[0].type.indexOf('image') !== -1) {
            imageReader = new FileReader();
            imageReader.readAsDataURL(imageSource[0]);
            imageReader.onload = function (imageEvent) {
                self.fullpath = imageEvent.target.result;
                initImageMeme();
            };//end imageReader.onload()
        }//end if
    }).bind(this);//end handleImageDrop()
    
    // Public methods
    this.refresh = function () {
        clearCanvas();
        drawImage();
        setTextOptions();
        drawText(topTextArr, true);
        drawText(bottomTextArr, false);
    };//end this.refresh()
    
    this.setTopText = function (text) {
        topTextArr = String(text).toUpperCase().split(' ');
        this.refresh();
    };//end this.addTopText()
    
    this.setBottomText = function (text) {
        bottomTextArr = String(text).toUpperCase().split(' ');
        this.refresh();
    };//end this.addBottomText()
    
    this.getImageData = function () {
        return canvas.toDataURL('image/png');
    };//end this.getImageData()
    
    // Constructor
    if (this.filename !== '') {
        initImageMeme();
    }//end if
    this.refresh();
    canvas.addEventListener('dragenter', blockEvent, false);
    canvas.addEventListener('dragover', blockEvent, false);
    canvas.addEventListener('drop', handleImageDrop, false);
}//end Meme()

//end meme-object.js
