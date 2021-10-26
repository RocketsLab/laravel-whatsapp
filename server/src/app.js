const app = require('express')(),
http = require('http').Server(app),
io = require('socket.io')(http),
bodyParser = require('body-parser'),
{ response } = require('./response'),
whatsapp = require('./whatsapp'),
{ listen } = require('./socket'),
chats = require('./routes/chatsRouter'),
groups = require('./routes/groupsRouter')
sessions = require('./routes/sessionRouter')

app.use(bodyParser.urlencoded({ extended: true }))
app.use(bodyParser.json())

app.use('/chats', chats)
app.use('/groups', groups)
app.use('/sessions', sessions)

const args = process.argv.splice(2)
const protocol = args[0] ?? 'http'
const host = args[1] ?? '127.0.0.1'
const hostPort = args[2] ?? "8000"

app.all('*', (req, res) => {
    response(res, 404, {success: false, message: 'The requested url cannot be found.'})
})

whatsapp.init()

http.listen(hostPort, () => {
    listen(io, whatsapp)
    console.info(`Server listening on ${protocol}://${host}:${hostPort}`)
})
