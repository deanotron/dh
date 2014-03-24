###
	Grunt build system
###
module.exports = (grunt) ->

	config =
		pkg: grunt.file.readJSON 'package.json'
		watch:
			stylus:
				files: ['css/*.styl']
				tasks: ['stylus', 'concat', 'cssmin']
			coffee:
				files: ['js/*.coffee']
				tasks: ['coffee', 'concat', 'uglify']  # coffee removed because WTF
				
		stylus:
			compile:
				files:
					'css/consulting.dev.css' : 'css/scaffold.styl'

		coffee:
			compile:
				files:
					'js/template.architect.js' : 'js/template.architect.coffee'
					'js/template.collection.js' : 'js/template.collection.coffee'
					# 'js/animation.architect.js' : 'js/animation.architect.coffee'
					'js/accordian.architect.js' : 'js/accordian.architect.coffee'
					'js/jquery.slider.js' : 'js/jquery.slider.coffee'
					'js/load.js' : 'js/load.coffee'
					'js/app.js' : 'js/app.coffee'
		
		csslint: 
			lax: 
				options: 
					import: false
				src: ['css/*.css']

		cssmin:
			dist: 
				src: [ 'css/consulting-concat.dev.css']
				dest: 'css/consulting.css'
				
		concat:
			dist:
				dest: 'js/consulting.development.js'
				src: [
					# "js/vendor/modernizr.custom.48341.js"
					"js/vendor/jquery-1.11.0.min.js"
					"js/vendor/underscore-min.js"
					# "js/vendor/TweenMax.min.js"
					# "js/vendor/ScrollToPlugin.min.js"
					# "js/vendor/AnimationFrame.min.js"
					# "js/template.collection.js"
					# "js/template.architect.js"
					# "js/animation.architect.js"
					# "js/accordian.architect.js"
					# "js/jquery.slider.js"
					"js/app.js"
					]
			cssconcat:
				dest: 'css/consulting-concat.dev.css'
				src: [
					'css/mfglabs_iconset.css',
					'css/normalize.css', 
					'css/consulting.dev.css',
					]
					
		uglify:
			build:
				src: 'js/consulting.development.js'
				dest: 'js/consulting.build.js'

		'sftp-deploy': 
			build: 
				auth: 
					host: '162.243.51.134'
					port: 22
					authKey: 'key1' # Need hidden file .ftppass for this
				src: '.' # Root Folder
				dest: '/home/wordpress/public_html/wp-content/themes/starkers-master'
				exclusions: ['./**/.DS_Store',
				'./LICENSE.txt',
				'./README.txt',
				'./404.php',
				'./archive.php',
				'./author.php',
				'./category.php',
				'./comments.php',
				'./archive.php',
				'./page.php',
				'./search.php',
				'./single.php',
				'./style.css',
				'./tag.php',
				'./screenshot.png',
				'./index*',
				'./npm*',
				'./external',
				'./img',
				# './parts',
				'./css/utility',
				'./css/easing.styl',
				'./css/easing.css',
				'./css/methods.styl',
				'./css/methods.css',
				'./js/vendor',
				'./js/polyfill',
				'./Gruntfile.js',
				'./Gruntfile.coffee',
				'./package.json',
				'./.git*',
				'./node_modules', 
				'./.ftppass', 
				'./ftppass.json']
				server_sep: '/'
		
		
	grunt.initConfig config

	grunt.loadNpmTasks 'grunt-contrib-coffee'
	grunt.loadNpmTasks 'grunt-contrib-concat'
	grunt.loadNpmTasks 'grunt-contrib-uglify'
	grunt.loadNpmTasks 'grunt-contrib-stylus'
	grunt.loadNpmTasks 'grunt-contrib-cssmin'
	grunt.loadNpmTasks 'grunt-contrib-csslint'
	grunt.loadNpmTasks 'grunt-contrib-watch'
	grunt.loadNpmTasks 'grunt-contrib-coffee'
	grunt.loadNpmTasks 'grunt-contrib-copy'
	grunt.loadNpmTasks 'grunt-sftp-deploy'
	
	
	
	
###
coffee:
	compile:
		files:
			'js/template.architect.js' : 'js/template.architect.coffee'
			'js/template.collection.js' : 'js/template.collection.coffee'
			'js/animation.architect.js' : 'js/animation.architect.coffee'
			'js/accordian.architect.js' : 'js/accordian.architect.coffee'
			'js/jquery.slider.js' : 'js/jquery.slider.coffee'
			'js/app.js' : 'js/app.coffee'
###
