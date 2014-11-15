function println(str)
{
    $("#output_msg").append('<br />');
    $("#output_msg").append(str);
}

/**
 * Aligns a grid of objects
 * 
 * @param cols       The number of columns in the grid
 * @param cellWidth  the width of each cell
 * @param cellHeight the height of each cell
 * @param padding    the padding between the cells
 */
function alignGrid(/*string*/ id, /*int*/ cols, /*int*/ cellWidth, /*int*/ cellHeight, /*int*/ padding) {
    
    var x = 0;
    var y = 0;
    var count = 1;
    
    jQuery("#" + id).each(function() {
        jQuery(this).css("position", "relative");
        
        jQuery(this).children("div").each(function() {
            jQuery(this).css("width", cellWidth + "em");
            jQuery(this).css("height", cellHeight + "em");
            jQuery(this).css("position", "absolute");
            
            jQuery(this).css("left", x + "em");
            jQuery(this).css("top", y + "em");
            
            if ((count % cols) == 0) {
                x = 0;
                y += cellHeight + padding;
            } else {
                x += cellWidth + padding;
            }
            
            count++;
        });
    });
}

/* 
 * Variables for handling the dynamic multigrid
 */
var gridcount = 0;
var gridwidth;
var gridheight;
var currentgrid = 0;

/* 
 * Positions the grid to a specific grid index.
 */
function positionGrid(/* int */ gridpos) {
    jQuery("#gridnav" + currentgrid).removeClass("gridnavitemselected");
    currentgrid = gridpos;
    jQuery(".multigrid").each(function() {
        jQuery(this).animate({ 
            left: "-" + (gridwidth * currentgrid) + "em"
            }, 1500 );
    });
    
    /*
     * Set the next and previous links to be visible as needed
     */
    if (currentgrid == 0) {
        jQuery("#prevcontainer").hide(0);
    } else {
        jQuery("#prevcontainer").show(0);
    }
    
    if (currentgrid == (gridcount - 1)) {
        jQuery("#nextcontainer").hide(0);
    } else {
        jQuery("#nextcontainer").show(0);
    }
    
    jQuery("#gridnav" + currentgrid).addClass("gridnavitemselected");
    
    return false;
}

/* 
 * Goes to the next grid position.  The is move right button
 */
function positionGridNext() {
    if (currentgrid == (gridcount - 1)) {
        return false;
    }
    
    positionGrid(currentgrid + 1);
    return false;
}

/* 
 * Goes to the previous grid position.  The is move left button
 */
function positionGridPrev() {
    if (currentgrid == 0) {
        return false;
    }
    
    positionGrid(currentgrid - 1);
    
    return false;
}

/* 
 * Adds an item to the grid navigation bar
 */
function addNavItem(index) {
    jQuery("#gridnav").append("<div id=\"gridnav" + (index  - 1) + "\" class=\"gridnavitem\"><a href=\"#\" " + 
                              "onclick=\"positionGrid(" + (index - 1) + "); return false;\">" + index + "</a></div>");

    /*
     * The navigation area needs to grow wide enough to hold all the items so we'll 
     * dynamically set the position of it based on the number of child nav items. 
     */
    jQuery("#gridnavcontainer").css("right", ((jQuery("#gridnav").children().length * 3) + 0.5) + "em" );
}

/**
 * Aligns a grid that spans multiple pages with dynamic links for 
 * navigation between the pages.
 * 
 * @param cols       The number of columns in the grid
 * @param cellWidth  the width of each cell
 * @param cellHeight the height of each cell
 * @param padding    the padding between the cells
 */
function alignMultiGrid(/*int*/ cols, /*int*/ cellWidth, /*int*/ cellHeight, /*int*/ padding) {
    
    var xoffset = padding;
    var x = xoffset;
    var y = padding;
    var cellcount = 1;
    var rowcount = 1;
    var maxrows = 2;
    
    gridwidth = (cols * (cellWidth + padding)) + padding;
    gridheight = (maxrows * (cellHeight + padding)) + padding;
    
    currentgrid = 0;
    
    /* 
     * First we add the styles and the navigation components to the main grid container
     */
    jQuery(".maingridcontainer").each(function() {
        jQuery(this).css("position", "relative");
        jQuery(this).css("width", (gridwidth + 5) + "em");
        jQuery(this).css("height", (gridheight + 5) + "em");
        
        
        /* 
         * Now we'll add the next and previous links
         */
        jQuery(this).append("<div class=\"nextprev\" id=\"nextcontainer\">" + 
                                "<a href=\"#\" id=\"next\"><img src=\"next.gif\" border=\"0\" /></a>" + 
                            "</div>");
        jQuery(this).append("<div class=\"nextprev\" id=\"prevcontainer\">" + 
                                "<a href=\"#\" id=\"prev\"><img src=\"prev.gif\" border=\"0\" /></a>" + 
                            "</div>");
        
        /* 
         * And now the previous and next link styling
         */
        jQuery("#prevcontainer").each(function() {
            jQuery(this).css("width", "4em");
            jQuery(this).css("height", "2em");
            jQuery(this).css("position", "absolute");
            
            jQuery(this).css("top", ((maxrows / 2) * (cellHeight + padding) - 0.5) + "em");
            jQuery(this).css("left", "0em");
        });
        
        jQuery("#nextcontainer").each(function() {
            jQuery(this).css("width", "4em");
            jQuery(this).css("height", "2em");
            jQuery(this).css("position", "absolute");
            
            jQuery(this).css("top", ((maxrows / 2) * (cellHeight + padding) - 0.5) + "em");
            jQuery(this).css("left", (gridwidth + 2) + "em");
        });
    });
    
    /* 
     * Now we style the grid container itself and add the navigation bar
     */
    jQuery(".multigridcontainer").each(function() {
        jQuery(this).css("overflow", "hidden");
        jQuery(this).css("position", "relative");
        jQuery(this).css("left", "2em");
        jQuery(this).css("width", gridwidth + "em");
        jQuery(this).css("height", (gridheight + 5) + "em");
        
        /* 
         * Add the grid navigation bar
         */
        jQuery(this).append("<div id=\"gridnavcontainer\"><div id=\"gridnav\" class=\"grid\"></div></div>");
        jQuery("#gridnavcontainer").each(function() {
            jQuery(this).css("position", "absolute");
            jQuery(this).css("top", (gridheight + 3) +  "em");
        });
    });
    
    /* 
     * And now we are ready to align the grid.  This is where 
     * the magic happens 
     */
    jQuery(".multigrid").each(function() {
        jQuery(this).css("position", "relative");
        
        jQuery(this).children("div").each(function() {
            jQuery(this).css("width", cellWidth + "em");
            jQuery(this).css("height", cellHeight + "em");
            jQuery(this).css("position", "absolute");
            
            jQuery(this).css("left", x + "em");
            jQuery(this).css("top", y + "em");
            
            if ((cellcount % cols) == 0) {
                if ((rowcount % maxrows) == 0) {
                    /* 
                     * This means we have added the maximum number of rows to 
                     * this page in the grid and we need to push everything 
                     * over to the next grid; 
                     */
                    y = padding;
                    xoffset += gridwidth;
                    x = xoffset;
                    gridcount++;
                    addNavItem(gridcount);
                    
                } else {
                    x = xoffset;
                    y += cellHeight + padding;
                }
                
                rowcount++;
            } else {
                x += cellWidth + padding;
            }
            
            cellcount++;
        });
        
        /* 
         * This is a little hacky.  I need to see if I have to add a 
         * grid to the grid count for a partial grid at the end.  I could 
         * make this code a bit cleaner if JQuery has a do/while construct 
         * instead of just a for each 
         */
        if ((cellcount - 1) % (maxrows * cols) != 0) {
            gridcount++;
            addNavItem(gridcount);
        }
        
    });
    
    /*
     * Now we have to align a simple grid for the navigation controls
     */
    alignGrid("gridnav", 6, 2, 2, 1);
    
    /* 
     * Add listeners for the next and previous links
     */
    jQuery("#next").click(function() {
        positionGridNext();
        return false;
    });
    
    jQuery("#prev").click(function() {
        positionGridPrev();
        return false;
    });
    
    /*
     * The last step is to position the grid to the 0 index so the first 
     * control will be properly highlighted
     */
    positionGrid(0);
    
    /*
     * Now that we have aligned the grid we add the listener for the right arrow, 
     * left arrow, home, and end key events for grid navigation. 
     */
    addListener(document, 'keyup', KeyCheck);
}

/*
 * Responds to the the right arrow, left arrow, home, and end key events for 
 * grid navigation. 
 */
var KeyCheck = function(e) {
    if(document.getElementById("tag").focused === false || document.getElementById("tag").focused === undefined || document.getElementById("tag").value.length === 0){
        var KeyID = (window.event) ? event.keyCode : e.keyCode;
        switch(KeyID) {
            case 37:    //the left arrow key
                positionGridPrev();
                break;
            case 39:    // the right arrow key
                positionGridNext();
                break;
        }
    }
};

/* 
 * Adds the KeyCheck listener for keyboard based grid navigation
 */
var addListener = function(element, type, expression, bubbling)
{
    bubbling = bubbling || false;
 
    if(window.addEventListener) { // Standard
        element.addEventListener(type, expression, bubbling);
        return true;
    } else if(window.attachEvent) { // IE
        element.attachEvent('on' + type, expression);
        return true;
    } else {
        return false;
    }
};



var isSubtitleExtendedVisible = false;

/*
 * Shows or hides the subtitle text.
 */
function showSub() {
    jQuery("#mainsubtitleextended").slideToggle("normal");
    isSubtitleExtendedVisible = !isSubtitleExtendedVisible;
    
    if (isSubtitleExtendedVisible) {
        jQuery("#subtitlereadmorelink").html("Less");
    } else {
        jQuery("#subtitlereadmorelink").html("More");
    }
    
    return false;
}
