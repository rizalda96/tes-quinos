import { extend } from 'vee-validate'
import * as rules from 'vee-validate/dist/rules'
import id from 'vee-validate/dist/locale/id'

// alpha, alpha_dash, alpha_num, alpha_spaces, between, confirmed, digits, dimensions, email,
// excluded, ext, image, integer, is, is_not, length, max, max_value, mimes, min, min_value,
// numeric, oneOf, regex, required, required_if, size
for (let rule in rules) {
    extend(rule, {
        // add the rule
        ...rules[rule],

        // add its message
        message: id.messages[rule]
    })
}
