from sqlalchemy import Column, Integer, String, ForeignKey
from sqlalchemy.orm import relationship
from database import Base


class User(Base):
    __tablename__ = 'users'

    id = Column(Integer, primary_key=True, index=True)
    username = Column(String(255), unique=True, index=True)
    password = Column(String(255))
    email = Column(String(255), unique=True, index=True)
    typer_user_id = Column(Integer, ForeignKey("typer_users.id"))

    typer_user = relationship("TyperUser", back_populates="users")
    written_news = relationship(
        "News", foreign_keys="News.writer_id", back_populates="writer")
    edited_news = relationship(
        "News", foreign_keys="News.editor_id", back_populates="editor")
