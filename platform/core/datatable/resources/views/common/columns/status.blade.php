<span @class([
    'badge',
    enum_default_status($status)->badge()
])>{{ enum_default_status($status)->description() }}</span>
