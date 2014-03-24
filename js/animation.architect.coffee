class AnimationArchitect

	constructor : ->

        @animations = {}
        @run        = false

        @vendors =
            webkit  : '-webkit-'
            gecko   : '-moz-'
            msie    : '-ms-'
            opera   : '-o-'

        console.log '===  | AnimationArchitect -> isModern | hasAttribute | ', @isModern()

	isModern : ->

        if Modernizr.csstransforms3d then return true

        else return false

    # checkAttributes : ->

    create : ( name, element, duration, attributes, ease, delay, callback ) ->

        unless @animations[ name ] then @animations[ name ] = [] 

        element     = if element instanceof jQuery then element else $ element
        duration    or= 1
        attributes  or= {}
        ease        or= 'linear'
        delay       or= 0
        callback    or= undefined

        opts = 
            element     : element 
            duration    : duration  
            attributes  : attributes
            ease        : ease
            delay       : delay
            callback    : callback

        @animations[ name ].push opts

        console.log '===  | AnimationArchitect -> Create | @animations | ', @animations

    animate : ( name, element, update, delay ) ->

        clearTimeout( timeoutID )

        if @animations[ name ]

            if typeof delay   isnt 'undefined' then @animations[ name ][0].delay = delay
            if typeof update  isnt 'undefined' and typeof update is 'object' then $.extend @animations[ name ][0].attributes, update 
            if typeof update  isnt 'undefined' and typeof update is 'number' then @animations[ name ][0].delay = update

            if element

                if typeof element is 'string'

                    element = @animations[ name ][0].element = $( element )
                    console.log( 'St', element )

                if element instanceof jQuery

                    $.extend @animations[ name ][0].attributes, element 
                    console.log( '$', element )

                else

                    @animations[ name ][0].element = $ element

            for set, i in @animations[ name ]
               
                if @isModern()

                    # User Request Animation Frame
                    animationFrame = window.AnimationFrame()
                    transitionList = []
                    propertiesList = {}

                    axis =
                        x : 0
                        y : 0 
                        z : 0
                    
                    animationFrame.cancel( runAnimation )

                    for attribute, value of set.attributes

                        if attribute is 'left'

                            axis.x = "-#{set.attributes.left}" 
                            delete set.attributes[ 'left' ]

                        if attribute is 'right'

                            axis.x = "#{set.attributes.right}" 
                            delete set.attributes[ 'right' ]

                        if attribute is 'top'

                            axis.y = "-#{set.attributes.top}" 
                            delete set.attributes[ 'top' ]

                        if attribute is 'bottom'

                            axis.y = "#{set.attributes.bottom}"
                            delete set.attributes[ 'bottom' ]

                    transform = "translate3d( #{axis.x}, #{axis.y}, #{axis.z} )"

                    if bowser.webkit then vendor = @vendors.webkit
                    if bowser.gecko  then vendor = @vendors.gecko
                    if bowser.msie   then vendor = @vendors.msie
                    if bowser.opera  then vendor = @vendors.opera

                    set.attributes[ "#{vendor}transform" ] = transform

                    for property of set.attributes

                        transitionList.push "#{property} #{set.duration}ms #{set.ease} #{set.delay}ms"

                    set.attributes[ "#{vendor}transition" ] = transitionList.join()

                    runAnimation = -> set.element.css( set.attributes )
                    if set.callback then runComplete  = -> set.callback()

                    animationFrame.request( runAnimation )

                    if set.callback then timeoutID = window.setTimeout( runComplete, set.duration + set.delay )

                else 

                    set.element.animate set.attributes, set.time, set.ease, set.callback


            console.log '=== | AnimationArchitect -> set | Name | ', @animations[ name ], transitionList 


root = exports ? window 
root.AnimationArchitect = AnimationArchitect
	

