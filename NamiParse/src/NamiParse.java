import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.nio.ByteBuffer;
import java.nio.ByteOrder;
import java.util.Arrays;

public class NamiParse {

	public static void main(String[] args) {
		new NamiParse().execute();
	}

	private void execute() {
		try {
			StringBuffer fileContent = new StringBuffer("");
			// File file = new File("c:\\temp\\db.nm2");
			File file = new File("c:\\temp\\tree.nm2");

			byte[] buf = readFile(file);
			parseBuffer(buf);

			System.out.println("end");

		} catch (FileNotFoundException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}

	private void parseBuffer(byte[] buf) {
		ByteBuffer bb = ByteBuffer.wrap(buf);
		bb.order(ByteOrder.LITTLE_ENDIAN);

		// リスト部分解析
		int length = bb.getInt();
		byte text[] = new byte[length];
		bb.get(text, 0, length);
		System.out.println(new String(text));

		// テキスト部分解析
		int textsize = 0;

		while (bb.hasRemaining()) {
			bb.order(ByteOrder.LITTLE_ENDIAN);
			textsize = bb.getInt();
			byte textS[] = new byte[textsize];
			bb.get(textS, 0, textsize);
			System.out.println("文字数: " +  textsize );
			int textsize2 = bb.getInt();
			System.out.println("カーソル位置: " +  textsize2 );
			System.out.println(new String(textS));
			System.out.print("アイコンもしくはツリー選択: ");
			strHex(bb);
		}
	}
	
	private void strHex(ByteBuffer bb){
		System.out.printf("%02X %02X %02X %02X", bb.get() & 0xff, bb.get() & 0xff, bb.get() & 0xff, bb.get() & 0xff);
		System.out.println("");
	}

	private byte[] readFile(File file) throws FileNotFoundException, IOException {
		FileInputStream input = new FileInputStream(file);
		int length = (int) file.length();
		byte buf[] = new byte[length];
		input.read(buf);
		input.close();
		return buf;
	}

}
