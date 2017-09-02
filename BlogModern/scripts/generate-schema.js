import generateSchema from 'json-to-graphql'
import data from '../../schema.json'

const schema = generateSchema(data)
    fs.writeFile('schema.js', schema, callback)
