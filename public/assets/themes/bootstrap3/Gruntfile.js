module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    less: {
      dev: {
        options: {
          paths: ["stylesheets", "stylesheets/less"],
          compress: true,
        },
        files: {
          "stylesheets/style.css": "stylesheets/style.less",
        }
      }
    },
  });
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.registerTask('default', [ 'less:dev' ]);
};