# SECURITY RULES

All inputs must be sanitized:
sanitize_text_field
sanitize_email
absint

All outputs must be escaped:
esc_html
esc_attr
esc_url

Nonce + capability check required.