const getters = {

    //  从联系人中提取出首字母 再排序

    contactsInitialList: state => {
        var initialList = [],
            allContacts = state.allContacts,
            max = allContacts.length
        for (var i = 0; i < max; i++) {
            if (initialList.indexOf(allContacts[i].initial.toUpperCase()) == -1) {
                initialList.push(allContacts[i].initial.toUpperCase())
            }
        }
        return initialList.sort()
    },

    // 将联系人根据首字母进行分类
    contactsList: (state, getters) => {
        var contactsList = {},
            allContacts = state.allContacts,
            max = allContacts.length;
        for (var i = 0; i < getters.contactsInitialList.length; i++) {
            var protoTypeName = getters.contactsInitialList[i]
            contactsList[protoTypeName] = []
            for (var j = 0; j < max; j++) {
                if (allContacts[j].initial.toUpperCase() === protoTypeName) {
                    contactsList[protoTypeName].push(allContacts[j])
                }
            }
        }
        return contactsList
    },
    token (state) {
        return state.token
    },
    filterUser : ({ filterUser }) => filterUser,

    currentUser : ({ currentUser }) => currentUser,  //current user

    users : ({ users }) => users,    //user list

    currentSession : ({ currentSession }) => currentSession,

    broadcast : ({ broadcast }) => broadcast,

    conn : ({ connection }) => {

        if (connection != null) {
            return connection;
        }
    },

    online : ({ online }) => online,

    currentCount : ({ currentCount }) => currentCount,

    notice : ({ notice }) => notice,

    friendslist : ({ friendslist }) => friendslist,

}

export default getters
