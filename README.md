joomoositestyle
===============

JoomooSitestyle: joomla template, component and module that allows users to customize the appearance of the site

 JoomooSiteStyle
=================
This extension consists of a Joomla template, component, and module that allow
users to customize the appearance of the site.

This extension uses Ajax and relies heavily on Javascript and Mootools.  It
does not degrade as gracefully as the other Joomoo extensions do when the user
has Javascript disabled.  (The author is willing to improve this, for a fee.)

 Features
----------
The JoomooSiteStyle extension allows users to set the following style parameters:

o  Font size
o  Background color
o  Border color
o  Border style
o  Border width

This extension also allows site administrators to set the following values in
the backend:

o  Default values for the style parameters that users can set (listed above)
o  The following additional style and template parameters:
   o  Link color
   o  Heading color
   o  Bullet color
   o  Input Element color
o  The following template parameters:
   o  A tag line above the site name
   o  The site name
   o  A tag line below the site name

The backend for the template also allows site administrators to set a parameter
causing the component and module to save the values for anonymous users in the
database rather than as a cookie in their browser.  This option is useful for
sites that have a large number of anonymous users and only a few number of
registered users.

 Database Columns
------------------
Following are the columns in the jos_joomoocomments table:

Field               Type                   Description
-------------------------------------------------------------------------------
id                  int(11) unsigned       Standard joomla primary key
user_id             int(11)                Foreign key: jos_users
ip_address          varchar(40)            IP address
background          varchar(20)            Background color
border_color_name   varchar(20)            Border color
border_style        varchar(20)            Border style
border_width        tinyint(1) unsigned    Border width in pixels
font_size           smallint(2) unsigned   Font size in pixels
timestamp           timestamp              Date and time stamp

Rather than rely on index tables for the background and border color and style,
which would be more efficient, this extension stores these parameters as
literal values.  This has the following advantages:

o  Makes it easier for non-technical people to add colors
o  Keeps the code simpler and easier to understand and debug

 JoomooSiteStyle Template Backend Parameters
---------------------------------------------
heading_color
    Color to use for headings; should be different than links
    Options: Blue, Green, Red, or Yellow
link_color
    Color to use for links; should be different than headings
    Options: Blue, Green, Red, or Yellow
bullet_color
    Color to use for bullets; match to headings (or links)
    Options: Blue, Green, Red, or Yellow
input_color
    Color to use for input elements; match to links (or headings)
    Options: Blue, Green, Red, or Yellow
tag_line_above
    Tag line above site name, for header on all pages
site_name
    Name of site, for header on all pages
tag_line_below
    Tag line below site name, for header on all pages
save_by_ip
    Save by IP?  Set to Yes to allow saving of parameters for non-logged in
        users in DB (by ip address)
    Options: Yes or No
default_background
    Default Background Color - user may override if component or module is enabled
    Options: Image, Black, Dark Blue, Dark Red, Very Dark Green, Very Dark Grey,
        Navy Blue, Dark Green, Seal Brown, Tyrian Purple, Persian Indigo, Bistre,
        Dark Scarlet, Army Green, Sapphire, or Falu Red
default_border_color_name
    Default Border Color - user may override if component or module is enabled
    Options: Blue, Green, Red, Yellow, Black, Cobalt, Pine Green,
        Dark Slate Grey, Slate Grey, Maroon, Grey, Violet, Silver,
        Shocking Pink, Orange Red, or White
default_border_style
    Default Border Style - user may override if component or module is enabled
    Options: Groove, Ridge, Double, Inset, Outset, Solid, Dashed, Dotted, or None
default_border_width
    Default Border Width - user may override if component or module is enabled
    Options Range from 0 to 30 pixels
default_font_size
    Default Font Size - user may override if component or module is enabled
    Options Range from 60% to 200% in increments of 5%

 JoomooSiteStyle Module Backend Parameters
-------------------------------------------
show_font_size
    Enable changing font size?
    Options: True or False
font_size_type
    Use dropdown or slider to change font size?
    Options: Dropdown or Slider
show_background
    Enable changing background?
    Options: True or False
show_border_color
    Enable changing border color?
    Options: True or False
show_border_style
    Enable changing border style?
    Options: True or False
show_border_width
    Enable changing border width?
    Options: True or False
border_width_type
    Use dropdown or slider to change border width?
    Options: Dropdown or Slider
show_reset_all
    Enable resetting all params to default?
    Options: True or False

