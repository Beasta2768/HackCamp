import dotenv
from langchain.chat_models import ChatOpenAI
from langchain.chains import ConversationChain, ConversationalRetrievalChain
from langchain.document_loaders import WebBaseLoader
from langchain.memory import ConversationSummaryMemory
from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain.embeddings import OpenAIEmbeddings
from langchain.vectorstores import Chroma
from langchain.load.dump import dumps

dotenv.load_dotenv("llm.env")


class llmCall:
    chat = ChatOpenAI()
    conversation = ConversationChain(llm=chat)

    def newprompt(self, prompt):
        nprompt = self.conversation.run(prompt)
        return nprompt

    def fileprocessor(self,file,prompt):
        loader = WebBaseLoader(file)
        data = loader.load()
        text_splitter = RecursiveCharacterTextSplitter(chunk_size=500, chunk_overlap=0)
        all_splits = text_splitter.split_documents(data)
        vectorstore = Chroma.from_documents(documents=all_splits, embedding=OpenAIEmbeddings())

        memory = ConversationSummaryMemory(
            llm=self.chat, memory_key="chat_history", return_messages=True
        )
        retriever = vectorstore.as_retriever()
        qa = ConversationalRetrievalChain.from_llm(self.chat, retriever=retriever, memory=memory)
        response = qa(prompt)
        return dumps(response.get("answer"))