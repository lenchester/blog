CREATE TABLE post (
                      id SERIAL PRIMARY KEY,   -- Automatically creates a sequence for auto-incrementing id
                      title VARCHAR(255) NOT NULL,
                      content TEXT NOT NULL
);
