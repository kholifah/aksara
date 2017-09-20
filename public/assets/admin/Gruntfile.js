// Gruntfile.js

// our wrapper function (required by grunt and its plugins)
// all configuration goes inside this function
module.exports = function(grunt) {

// ===========================================================================
// CONFIGURE GRUNT ===========================================================
// ===========================================================================
	grunt.initConfig({

		// get the configuration info from package.json ----------------------------
		// this way we can use things like name and version (pkg.name)
		pkg: grunt.file.readJSON('package.json'),

		// configure jshint to validate js files -----------------------------------
		jshint: {
			options: {
				reporter: require('jshint-stylish') // use jshint-stylish to make our errors look and read good
			},

			// when this task is run, lint the Gruntfile and all js files in src
			build: ['Gruntfile.js', 'src/**/*.js']
		},

		// configure sass for styling sheet -----------------------------------
		sass: {
			// this is the "dev" Sass config used with "grunt watch" command
			dev: {
				options: {
					outputStyle: 'compressed',
					sourceMap: 'string',
					// tell Sass to look in the Bootstrap stylesheets directory when compiling
					loadPath: 'assets/sass'
				},
				files: {
						// the first path is the output and the second is the input
						'dist/css/style.css': 'assets/sass/style.scss'
						
						/*'dist/css/style-1.css': 'assets/sass-1/style.scss',
				 		'dist/css/style-2.css': 'assets/sass-2/style.scss'*/
					}
				},
			 // this is the "production" Sass config used with the "grunt buildcss" command
			dist: {
			 	options: {
			 		outputStyle: 'compressed',
			 		loadPath: 'assets/sass'
			 	},
			 	files: {
			 		'dist/css/style.css': 'assets/sass/style.scss'

			 		/*'dist/css/style-1.css': 'assets/sass-1/style.scss',
			 		'dist/css/style-2.css': 'assets/sass-2/style.scss'*/
			 	}
			},
		},

		uglify: {
		    production: {
		    	options: {
			        sourceMap: true,
			        sourceMapName: 'path/to/sourcemap.map'
		    	},
		      	files: {
		        	'dist/js/script.min.js': ['assets/js/jquery.min.js', 'assets/js/libs/*.js', 'assets/js/jquery.core.js', 'assets/js/jquery.app.js', 'assets/js/script.js'],
		    	},
		    },
		},

		// configure the "grunt watch" task -----------------------------------
		watch: {
			javascript: {
		        files: 'assets/js/**/*.js',
		        tasks: 'uglify:production'
		    },
		 	scripts: {
		 		files: ['assets/**/*.scss'],
		 		tasks: ['sass:dev', 'jshint']
		 	}
		}
	});

	grunt.registerTask('default', ['watch']);
	grunt.registerTask('style', [ 'uglify:production']);
	// ===========================================================================
	// LOAD GRUNT PLUGINS ========================================================
	// ===========================================================================
	// we can only load these if they are in our package.json
	// make sure you have run npm install so our app can find these
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	// "grunt buildcss" is the same as running "grunt sass:dist".
	// if I had other tasks, I could add them to this array.
	grunt.registerTask('build', ['sass:dist']);
};