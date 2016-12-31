# ThemeBundle
A Symfony Theme Bundle System

/*
    Symfony Themesbundle, to allow easy changing of themes, and body backgrounds.
    Copyright (C) 2016  Justin Fuhrmeister-Clarke 

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/



please enable:
            new ThemesBundle\ThemesBundle(),

in AppKernal.php

To enable Routing please place the below in app/config/routing.yml

themes:
    resource: "@ThemesBundle/Resources/config/routing.yml"
    prefix:   /themes


To enable these themes please place the below at the base of either layout.html.twig or base.html.twig.

    <!-- start theme Embed -->
    {{ render(controller( 'ThemesBundle:Default:footer' )) }}
    <!-- end theme Embed -->



Any issues please log them at github issues.
