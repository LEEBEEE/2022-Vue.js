export default {
    getTimestamp: function(date) {
        date.setHours(date.getHours() + 9);
        return date.toISOString().replace('T', ' ').substring(0, 19);
    }
}