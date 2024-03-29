/*
# Movable Type (r) Open Source (C) 2003-2008 Six Apart, Ltd.
# This program is distributed under the terms of the
# GNU General Public License, version 2.
#
# $Id: window.js 1174 2008-01-08 21:02:50Z bchoate $
*/


/*
--------------------------------------------------------------------------------
TC.Window
dom window class
--------------------------------------------------------------------------------
*/

/* constructor */

TC.Window = function()
{
	this.element = document.createElement( "div" );
	this.element.style.display = "block";
	this.element.style.visibility = "hidden";
	this.visible = false;
	this.quick = false;
	this.attached = false;
	
	var self = this;
	this.clickOutsideClosure = function( evt )
	{
		return self.clickOutside( evt );
	}
}


/* instance methods */

TC.Window.prototype.attach = function()
{
	if( this.attached )
		return;
	document.body.appendChild( this.element );
	TC.attachDocumentEvent( window, "mousedown", this.clickOutsideClosure, true );	// recurse to all [i]frames
	this.attached = true;
}


TC.Window.prototype.clickOutside = function( evt )
{
	if( !this.quick || !this.visible )
		return;
	
	// try to find our "window" element in dom hierarchy
	evt = evt || event;
	var element = evt.target || evt.srcElement;
	while( element )
	{
		if( element == this.element )
			return true;
		element = element.parentNode;
	}
	
	this.hide();
	return true;
}


TC.Window.prototype.setStyle = function( style )
{
	return TC.setStyle( this.element, style );
}


TC.Window.prototype.setAttributes = function( attr )
{
	return TC.setAttributes( this.element, attr );
}


TC.Window.prototype.show = function()
{
	this.element.style.visibility = "visible";
	this.visible = true;
}


TC.Window.prototype.hide = function()
{
	this.element.style.visibility = "hidden";
	this.visible = false;
}
