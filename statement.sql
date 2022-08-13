SELECT
    tbl_users.id,
    tbl_users.email,
    tbl_users.name,
    MAX(
        CASE WHEN tbl_users_meta.meta_key = 'ip_address' THEN tbl_users_meta.meta_value
    END
) ip_address,
MAX(
    CASE WHEN tbl_users_meta.meta_key = 'referrer' THEN tbl_users_meta.meta_value
END
) referrer,
MAX(
    CASE WHEN tbl_users_meta.meta_key = 'user_agent' THEN tbl_users_meta.meta_value
END
) user_agent,
CONCAT(
    '[',
    GROUP_CONCAT(
        CONCAT(
            '"',
            tbl_users_images.url_path,
            '"'
        )
    ),
    ']'
) path
FROM
    tbl_users
INNER JOIN tbl_users_meta ON tbl_users.id = tbl_users_meta.user_id
INNER JOIN tbl_users_images ON tbl_users.id = tbl_users_images.user_id
GROUP BY
    tbl_users_meta.user_id