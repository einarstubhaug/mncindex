module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      options: {
        banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
      },
      jsplot: {
        src: ['assets/js/thirdparty/jquery.jqplot.min.js', 'assets/js/thirdparty/jqplot-plugins/*'],
        dest: 'assets/js/thirdparty/jqplot-bundle.min.js'
      },
      mncindex: {
        src: [
          'assets/js/mncindex.js', 'assets/js/mncindex_app/app.js',
          'assets/js/mncindex_app/controllers/**.js'],
        dest: 'assets/js/mncindex_bundle.min.js'
      }
    }
  });

  // Load the plugin that provides the "uglify" task.
  grunt.loadNpmTasks('grunt-contrib-uglify');

  // Default task(s).
  grunt.registerTask('default', ['uglify']);

};