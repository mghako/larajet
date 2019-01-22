export default class Gate{
    constructor(user) {
        this.user = user
    }

    isAdmin() {
        return this.user.type === 'admin'
    }
    isPoster() {
        return this.user.type === 'poster'
    }
    isMember() {
        return this.user.type === 'member'
    }
    isAdminOrAuthor() {
        if(this.user.type === 'admin' || this.user.type === 'author') {
            return true
        }
        
    }
}