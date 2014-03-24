class TemplateArchitect

   constructor : ->

        @templates = {}

    add : ( id, name, template, callback ) ->

        unless @templates[ name ] then @templates[ name ] = [] 

        opts = 
            id           : id
            template     : _.template( template )
            callback     : callback

        @templates[ name ].push opts

        console.log '=== TEMPLATES ===>', @templates

    remove : ( id, name ) ->
        
        # Templates names match but not their ids
        remnants = []

        if @templates[ name ]
            
            for template in @templates[ name ]

                remnants.push template if template.id isnt id

            if remnants.length is 0 then delete @templates[ name ]

            else @templates[ name ] = remnants

    build : ( id, name, data ) ->

        model = { model : data } 

        for setName, sets of @templates

            return false if not ( sets != null )

            if setName is name 

                for set in sets

                    console.log id, name, model

                    set.callback( model )


# USE CASES
# builder = new TemplateArchitect
# builder.add( 'id01', 'landscape', '<div class="some-class" ></div>', function(){ console.log( 'called beetach' )  } )
# builder.add( 'id02', 'landscape', '<div class="some-class" ></div>', function(){ console.log( this.template )  } )
# builder.add( 'id03', 'landscape', '<div class="some-class" ></div>', function(){ console.log( this.template )  } )
# builder.add( 'id01', 'people', '<div class="some-class" ><%- model.peoples %></div>', function( data ){ $( 'body' ).append( this.template( data ) ); } )
# builder.build( 'id01', 'people', { peoples : 'uhhuhher', sabii : 'zipzang' } )
     
root = exports ? window 
root.TemplateArchitect = TemplateArchitect













