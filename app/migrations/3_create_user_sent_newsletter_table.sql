CREATE TABLE IF NOT EXISTS user_sent_newsletter (
    user_number BIGINT UNSIGNED NOT NULL,
    job_id INTEGER NOT NULL,
    FOREIGN KEY (user_number) REFERENCES users(`number`),
    FOREIGN KEY (job_id) REFERENCES jobs(id)
);